<?php
namespace App\Listeners;
use App\Events\CourseEventBooked;
use App\Mail\BookingConfirmationStudent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CourseEventStudentConfirm
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
   * @param  CourseEventBooked  $event
   * @return void
   */
  public function handle(CourseEventBooked $event)
  {
    $courseEvent  = $event->courseEvent;
    $student  = $event->student;

    Mail::to($student->user->email)
          ->cc([\Config::get('sipt.email_cc')])
          ->send(
              new BookingConfirmationStudent(
                [
                  'student' => $student,
                  'courseEvent' => $courseEvent,
                ]
          )
    );
  }
}
