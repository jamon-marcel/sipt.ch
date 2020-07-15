<?php
namespace App\Listeners;
use App\Events\CourseEventCancelled;
use App\Mail\BookingCancelStudent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CourseEventStudentCancel
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  /**
   * Handle the event.
   *
   * @param  CourseEventCancelled $event
   * @return void
   */
  public function handle(CourseEventCancelled $event)
  {
    $courseEvent  = $event->courseEvent;
    $student  = $event->student;

    Mail::to($student->user->email)
          ->cc([\Config::get('sipt.email_cc')])
          ->send(
              new BookingCancelStudent(
                [
                  'student' => $student,
                  'courseEvent' => $courseEvent,
                ]
          )
    );
  }
}
