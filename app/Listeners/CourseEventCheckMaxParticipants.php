<?php
namespace App\Listeners;
use App\Events\CourseEventParticipantsChanged;
use App\Models\CourseEventStudent;
use App\Mail\CourseEventFullyBookedNotification;
use App\Mail\CourseEventReopenedNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CourseEventCheckMaxParticipants
{
  protected $courseEvent;
  protected $courseEventStudent;

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
   * @param  CourseEventParticipantsChanged $event
   * @return void
   */
  public function handle(CourseEventParticipantsChanged $event)
  {
    $this->courseEvent = $event->courseEvent;

    $max     = $this->courseEvent->max_participants;
    $current = $this->courseEventStudent->where('course_event_id', '=', $this->courseEvent->id)->count();

    if ($max == $current)
    {
      $this->courseEvent->is_bookable = 0;
      $this->courseEvent->save();
      $this->notifyFull();
    }

    if ($max > $current && $this->courseEvent->is_bookable == 0)
    {
      $this->courseEvent->is_bookable = 1;
      $this->courseEvent->save();
      $this->notifyReopen();
    }
  }

  /**
   * Send the fully booked notification for the event
   * 
   * @return void
   */

  public function notifyFull()
  {
    Mail::to(\Config::get('sipt.email_admin'))
        ->cc(\Config::get('sipt.email_cc'))
        ->send(
            new CourseEventFullyBookedNotification(
              [
                'courseEvent' => $this->courseEvent,
              ]
        )
    );
  }

  /**
   * Send the reopen notification for the event
   * 
   * @return void
   */

  public function notifyReopen()
  {
    Mail::to(\Config::get('sipt.email_admin'))
        ->cc(\Config::get('sipt.email_cc'))
        ->send(
            new CourseEventReopenedNotification(
              [
                'courseEvent' => $this->courseEvent,
              ]
        )
    );
  }

}
