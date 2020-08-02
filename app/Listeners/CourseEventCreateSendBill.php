<?php
namespace App\Listeners;
use App\Services\CourseInvoice;
use App\Mail\CourseEventBillingNotification;
use App\Events\CourseEventBill;
use App\Models\CourseEvent;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;

class CourseEventCreateSendBill
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct(CourseEvent $courseEvent)
  {
    $this->courseEvent = $courseEvent;
  }

  /**
   * Handle the event.
   *
   * @param  CourseEventBill $event
   * @return void
   */
  public function handle(CourseEventBill $event)
  {
    $notifyUser = $event->notifyUser;

    // Get billable courses with billableStudents
    $courseEvents = $this->courseEvent->with('course', 'dates', 'billableStudents')->billable();

    // Filter out empty course events without students
    $courseEventsWithStudents = $courseEvents->filter(function($courseEvent) {
      return $courseEvent->billableStudents->count() > 0;
    });

    if ($courseEventsWithStudents->count())
    {    
      // Loop over all events  
      foreach($courseEventsWithStudents as $courseEvent)
      {
        // Build chunk
        $students = collect($courseEvent->billableStudents)->splice(0, \Config::get('sipt.cron_chunk_size'));

        // Loop over chuncked students
        foreach($students->all() as $student)
        {
          // Create Invoice
          $invoice = $this->invoice($student, $courseEvent);

          // Notify User
          if ($notifyUser)
          {
            $this->notify($invoice, $student, $courseEvent);
          }
        }
      }
    }
  }

  /**
   * Create the course invoice
   * 
   * @param $invoice
   * @return $invoice
   */
  
  public function invoice($student, $courseEvent)
  {
    $courseInvoice = new CourseInvoice();
    $courseInvoice->create([
      'date'  => date('d.m.Y', time()),
      'amount' => $courseEvent->course->cost,
      'client' => $student,
      'booking_number' => $student->pivot->booking_number,
      'course_event' => $courseEvent,
    ]);
          
    // Write to disk
    $courseInvoice->write();

    // Store in database
    $invoice = $courseInvoice->store();

    return $invoice;
  }

  /**
   * Send mail to student
   * 
   * @param $invoice
   * @return void
   */

  public function notify($invoice, $student, $courseEvent)
  {
    Mail::to(\Config::get('sipt.email_admin'))
          ->cc(\Config::get('sipt.email_cc'))
          ->send(
              new CourseEventBillingNotification(
                [
                  'student'         => $student,
                  'courseEvent'     => $courseEvent,
                  'invoice_number'  => $invoice->number,
                  'invoice_amount'  => $invoice->amount,
                  'attachment'     => public_path() . '/storage/invoices/' . $invoice->file
                ]
          )
    );
  }
}
