<?php
namespace App\Listeners;
use App\Models\CourseEventStudent;
use App\Models\Invoice;
use App\Services\PaymentSlip;
use App\Mail\SendStudentInvoice;
use App\Events\StudentInvoice;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateSendStudentInvoice
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct(CourseEventStudent $courseEventStudent)
  {
    $this->courseEventStudent = $courseEventStudent;
  }

  /**
   * Handle the event.
   *
   * @param  StudentInvoice $event
   * @return void
   */
  public function handle(StudentInvoice $event)
  {
    $student        = $event->student;
    $courseEvent    = $event->courseEvent;
    $invoiceNumber  = Invoice::max('number') + 1;
          
    $data = [
      'invoice_number' => ($invoiceNumber > \Config::get('sipt.min_invoice_number')) ? $invoiceNumber : \Config::get('sipt.min_invoice_number'),
      'invoice_date'   => date('d.m.Y', time()),
      'invoice_amount' => $courseEvent->course->cost,
      'client_number'  => $student->number,
      'booking_number' => $student->pivot->booking_number,
      'student'        => $student,
      'courseEvent'    => $courseEvent
    ];

    $this->viewData['invoice'] = $data;

    // Get payment slip data
    $paymentSlip = new PaymentSlip($data['client_number'], $data['booking_number'], $data['invoice_number'], $data['invoice_amount']);
    $this->viewData['payment_slip'] =  $paymentSlip->get();
          
    // Load pdf view
    $pdf  = PDF::loadView('pdf.invoice.course', $this->viewData);

    // Set filename
    $file = 'sipt_rechnung-' . $data['invoice_number'] . '-' . date('d-m-Y-H-i-s', time()) . '.pdf';

    // Save file to disk
    $pdf->save(public_path() . '/storage/invoices/' . $file);

    // Store invoice data
    $invoice = Invoice::create([
      'number' => $data['invoice_number'],
      'date'   => $data['invoice_date'],
      'file'   => $file,
      'student_id' => $student->id,
      'course_event_id' => $courseEvent->id
    ]);
    $invoice->save();
    
    // Store 'is_billed' on pivot table
    $course_event_student = $this->courseEventStudent->where('student_id', '=', $student->id)
                                                     ->where('course_event_id', '=', $courseEvent->id)
                                                     ->get()->first();
    $course_event_student->is_billed = 1;
    $course_event_student->save();
    
    // Send mail to student
    Mail::to($student->user->email)
          ->cc([\Config::get('sipt.email_cc')])
          ->send(
              new SendStudentInvoice(
                [
                  'student'         => $student,
                  'courseEvent'     => $courseEvent,
                  'invoice_number'  => $data['invoice_number'],
                  'pdf'             => public_path() . '/storage/invoices/' . $file
                ]
          )
    );
  }
}
