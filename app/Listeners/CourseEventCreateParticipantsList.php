<?php
namespace App\Listeners;
use App\Events\CourseEventParticipantsList;
use App\Services\Document;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CourseEventCreateParticipantsList
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct()
  {
  }

  /**
   * Handle the event.
   *
   * @param  CourseEventParticipantsList $event
   * @return void
   */
  public function handle(CourseEventParticipantsList $event)
  {
    $courseEvent = $event->courseEvent;
    $document = new Document();
    return $document->participantList($courseEvent->id);
  }
}
