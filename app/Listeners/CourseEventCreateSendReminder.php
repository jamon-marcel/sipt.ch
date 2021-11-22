<?php
namespace App\Listeners;
use App\Services\Document;
use App\Events\CourseEventReminder;
use App\Models\CourseEvent;
use App\Models\Tutor;
use App\Mail\CourseEventReminderNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CourseEventCreateSendReminder
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct(Tutor $tutor, CourseEvent $courseEvent)
  {
    $this->tutor = $tutor;
    $this->courseEvent = $courseEvent;
  }

  /**
   * Handle the event.
   *
   * @param  CourseEventReminder $event
   * @return void
   */
  public function handle(CourseEventReminder $event)
  {
    // Get callable courses with billableStudents
    $courseEvents = $this->courseEvent->with('course', 'dates.tutor.user', 'location')->reminder();
    
    // Build chunk
    $chunkedCourseEvents = collect($courseEvents)->splice(0, \Config::get('sipt.cron_chunk_size'));

    // Loop over all events  
    foreach($chunkedCourseEvents as $courseEvent)
    {
      // Loop over all dates and get tutor data
      $tutors = [];
      foreach($courseEvent->dates as $date)
      {
        $tutors[$date->tutor->id] = $date->tutor;
      }

      if (!empty($tutors))
      {
        // Update 'has_reminder' attribute
        $courseEvent->has_reminder = 1;
        $courseEvent->save();

        // Notify tutor
        $this->notify($courseEvent, $tutors);
      }
    }
  }

  /**
   * Send mail to tutors
   * 
   * @param $courseEvent
   * @param $tutors
   * @return void
   */
  public function notify($courseEvent, $tutors)
  {
    $hasMap = false;
    if ($courseEvent->location->maps_file && !$courseEvent->is_online)
    {
      $attachments[] =  public_path() . '/storage/uploads/' . $courseEvent->location->maps_file;
      $hasMap = true;
    }

    foreach($tutors as $tutor)
    {
      Mail::to($tutor->user->email)
      ->bcc(\Config::get('sipt.email_copy'))
      ->send(
          new CourseEventReminderNotification(
            [
              'tutor' => $tutor,
              'courseEvent' => $courseEvent,
              'attachments' => $attachments,
              'hasMap' => $hasMap
            ]
          )
      );
    }
  }
}
