<?php
namespace App\Http\Controllers;


use App\Models\Student;
use App\Models\CourseEvent;
use App\Models\CourseEventStudent;
use App\Models\Invoice;

use App\Events\CourseEventBill;

use App\Services\PaymentSlip;
use PDF;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class TestController extends BaseController
{
  public function __construct(CourseEvent $courseEvent, Student $student, Invoice $invoice)
  {
    parent::__construct();
    $this->courseEvent = $courseEvent;
    $this->student = $student;
    $this->invoice = $invoice;
  }

  public function invoice()
  {

    // external data
    $client_number    = 1168;
    $invoice_number   = 605277;
    $booking_number   = 409300;
    $amount           = '125';

    $paymentSlip = new PaymentSlip($client_number,  $invoice_reservation_no, $booking_number, $invoice_amount);
    $this->viewData['invoice'] =  $paymentSlip->get();
   
    
    $this->viewData['subscriber'] = [];
    $pdf  = PDF::loadView('pdf.bill.course', $this->viewData);

    // Set path & filename
    $path = public_path() . '/storage/invoices/';
    $file = 'sipt_rechnung-' . date('d.m.Y-H.i.s', time()) . '.pdf';

    // Store file
    $pdf->save($path . '/' . $file);
  }

  public function billable()
  {
    // Get billable courses with billableStudents
    $courseEvents = $this->courseEvent->with('course', 'dates', 'billableStudents')->billable();

    // Filter out empty 'billableStudents' relationships
    $courseEventsWithStudents = $courseEvents->filter(function($courseEvent) {
      return $courseEvent->billableStudents->count() > 0;
    });

    if ($courseEventsWithStudents->count())
    {
      foreach($courseEventsWithStudents as $courseEvent)
      {
        foreach($courseEvent->billableStudents as $student)
        {
          event(new CourseEventBill($student, $courseEvent));
        }
      }
    }
  }


  public function reminder(Invoice $invoice)
  {

    $student = $this->student->with('user')->where('id', '=', $invoice->student_id)->get()->first();
    $courseEvent = $this->courseEvent->with('course', 'dates')->where('id', '=', $invoice->course_event_id)->get()->first();

    dd($courseEvent);

    event(new CourseEventBill($student, $courseEvent));


    // // Get billable courses with billableStudents
    // $courseEvents = $this->courseEvent->with('course', 'dates', 'billableStudents')->billable();

    // // Filter out empty 'billableStudents' relationships
    // $courseEventsWithStudents = $courseEvents->filter(function($courseEvent) {
    //   return $courseEvent->billableStudents->count() > 0;
    // });

    // if ($courseEventsWithStudents->count())
    // {
    //   foreach($courseEventsWithStudents as $courseEvent)
    //   {
    //     foreach($courseEvent->billableStudents as $student)
    //     {
    //       event(new CourseEventBill($student, $courseEvent));
    //     }
    //   }
    // }
  }
}
