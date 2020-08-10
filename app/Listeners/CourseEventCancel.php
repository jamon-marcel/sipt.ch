<?php
namespace App\Listeners;
use App\Events\CourseEventCancelled;
use App\Mail\CourseEventCancelNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CourseEventCancel
{

  protected $student;
  protected $courseEvent;
  protected $courseEventStudent;

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
    $this->student            = $event->student;
    $this->courseEvent        = $event->courseEvent;
    $this->courseEventStudent = $event->courseEventStudent;

    // Delete courseEvent for student
    $this->courseEventStudent->is_cancelled = 1;
    $this->courseEventStudent->cancelled_at = date('d.m.Y', time());
    $this->courseEventStudent->save();
    $this->courseEventStudent->delete();
    $this->notify();
  }

  public function notify()
  {
    Mail::to($this->student->user->email)
          ->bcc(\Config::get('sipt.email_copy'))
          ->send(
              new CourseEventCancelNotification(
                [
                  'student' => $this->student,
                  'courseEvent' => $this->courseEvent,
                ]
          )
    );
  }
}
