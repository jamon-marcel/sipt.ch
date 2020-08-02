<?php
namespace App\Events;
use App\Models\Student;
use App\Models\CourseEvent;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CourseEventInvitation
{
  use Dispatchable, SerializesModels;
  
  /**
   * Create a new event instance.
   * @param Student $student
   * @param CourseEvent $courseEvent
   * @return void
   */
  public function __construct()
  {

  }
}
