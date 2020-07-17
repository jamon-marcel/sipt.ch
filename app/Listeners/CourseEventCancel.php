<?php
namespace App\Listeners;
use App\Events\CourseEventCancelled;
use App\Mail\CourseEventCancelNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CourseEventCancel
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
    $student            = $event->student;
    $courseEvent        = $event->courseEvent;
    $courseEventStudent = $event->courseEventStudent;

    // Delete courseEvent for student
    $courseEventStudent->delete();

    Mail::to($student->user->email)
          ->cc(\Config::get('sipt.email_cc'))
          ->send(
              new CourseEventCancelNotification(
                [
                  'student' => $student,
                  'courseEvent' => $courseEvent,
                ]
          )
    );
  }
}
