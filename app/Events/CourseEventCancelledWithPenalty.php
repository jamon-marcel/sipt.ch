<?php
namespace App\Events;
use App\Models\Student;
use App\Models\CourseEvent;
use App\Models\CourseEventStudent;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CourseEventCancelledWithPenalty
{
  use Dispatchable, SerializesModels;

  public $student;
  public $courseEvent;
  public $courseEventStudent;
  public $penalty;
  
  /**
   * Create a new event instance.
   * @param Student $student
   * @param CourseEvent $courseEvent
   * @param Integer $penalty
   * @return void
   */
  public function __construct(Student $student, CourseEventStudent $courseEventStudent, CourseEvent $courseEvent, $penalty)
  {
    $this->student = $student;
    $this->courseEvent = $courseEvent;
    $this->courseEventStudent = $courseEventStudent;
    $this->penalty = $penalty;
  }
}
