<?php
namespace App\Listeners;
use App\Models\CourseEventStudent;
use App\Models\Invoice;
use App\Services\PaymentSlip;
use App\Mail\CourseEventCancelBillingNotification;
use App\Events\CourseEventCancelledWithPenalty;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CourseEventCancelWithPenalty
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct(CourseEventStudent $courseEventStudent, Invoice $invoice)
  {
    $this->courseEventStudent = $courseEventStudent;
    $this->invoice = $invoice;
  }

  /**
   * Handle the event.
   *
   * @param  CourseEventCancelledWithPenalty $event
   * @return void
   */
  public function handle(CourseEventCancelledWithPenalty $event)
  {
    $student            = $event->student;
    $courseEvent        = $event->courseEvent;
    $courseEventStudent = $event->courseEventStudent;
    $penalty            = $event->penalty;

    // Create invoice number
    $invoiceNumber  = \InvoiceHelper::getNumber();;
    
    // Set data
    $data = [
      'invoice_number' => $invoiceNumber,
      'invoice_date'   => date('d.m.Y', time()),
      'invoice_amount' => \MoneyFormatHelper::number(($courseEvent->course->cost * $penalty)/100),
      'client_number'  => $student->number,
      'booking_number' => $courseEventStudent->booking_number,
      'student'        => $student,
      'courseEvent'    => $courseEvent
    ];
    $this->viewData['invoice'] = $data;

    // Get payment slip data
    $paymentSlip = new PaymentSlip($data['client_number'], $data['booking_number'], $data['invoice_number'], $data['invoice_amount']);
    $this->viewData['payment_slip'] =  $paymentSlip->get();
          
    // Load pdf view
    $pdf = PDF::loadView('pdf.bill.course-cancel', $this->viewData);

    // Set filename
    $file = 'sipt_rechnung-' . $data['invoice_number'] . '-' . date('d-m-Y-H-i-s', time()) . '.pdf';

    // Save file to disk
    $pdf->save(public_path() . '/storage/invoices/' . $file);

    // Store invoice data
    $invoice = Invoice::create([
      'number'          => $data['invoice_number'],
      'date'            => $data['invoice_date'],
      'amount'          => $data['invoice_amount'],
      'file'            => $file,
      'student_id'      => $student->id,
      'course_event_id' => $courseEvent->id
    ]);
    $invoice->save();
    
    // Check for existing bills
    if ($courseEventStudent->is_billed == 1)
    {
      $old_invoices = $this->invoice->where('student_id', '=', $student->id)->where('course_event_id', '=', $courseEvent->id)->get();
      foreach($old_invoices as $oi)
      {
        if ($oi->id != $invoice->id)
        {
          $oi->replaced_by = $invoice->id;
          $oi->save();
          $oi->delete();
        }
      }

      $invoice->is_replacement = 1;
      $invoice->save();
    }

    // Set cancelled attributes
    $courseEventStudent->is_cancelled = 1;
    $courseEventStudent->cancelled_at = date('d.m.Y', time());
    $courseEventStudent->is_billed = 1;
    $courseEventStudent->save();
    $courseEventStudent->delete();
    
    // Send mail to student
    Mail::to($student->user->email)
          ->bcc(\Config::get('sipt.email_copy'))
          ->send(
              new CourseEventCancelBillingNotification(
                [
                  'student'         => $student,
                  'courseEvent'     => $courseEvent,
                  'penalty'         => $penalty,
                  'invoice_number'  => $data['invoice_number'],
                  'invoice_amount'  => $data['invoice_amount'],
                  'pdf'             => public_path() . '/storage/invoices/' . $file
                ]
          )
    );
  }
}
