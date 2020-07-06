<?php
namespace App\Events;
use App\Models\CourseEvent;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CourseEventParticipantsList
{
  use Dispatchable, SerializesModels;

  public $courseEvent;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct(CourseEvent $courseEvent)
  {
    $this->courseEvent = $courseEvent;
  }
}
