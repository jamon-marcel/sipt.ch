<?php
namespace App\Listeners;
use App\Events\CourseEventBooked;
use App\Mail\CourseEventConfirmationNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CourseEventConfirm
{

  protected $courseEvent;
  protected $student;

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
    $this->courseEvent  = $event->courseEvent;
    $this->student      = $event->student;
    $this->notify();
  }

  /**
   * Send the notification for the event
   * 
   * @return void
   */
  
  public function notify()
  {
    Mail::to($this->student->user->email)
          ->bcc(\Config::get('sipt.email_copy'))
          ->send(
              new CourseEventConfirmationNotification(
                [
                  'student' => $this->student,
                  'courseEvent' => $this->courseEvent,
                ]
          )
    );
  }
}
