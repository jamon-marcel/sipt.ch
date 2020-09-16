<?php
namespace App\Events;
use App\Models\Tutor;
use App\Models\CourseEvent;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CourseEventReminder
{
  use Dispatchable, SerializesModels;
  
  /**
   * Create a new event instance.
   * @param Tutor $tutor
   * @param CourseEvent $courseEvent
   * @return void
   */
  public function __construct()
  {

  }
}
