<?php
namespace App\Events;
use App\Models\Student;
use App\Models\CourseEvent;
use App\Models\CourseEventStudent;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CourseEventCancelled
{
  use Dispatchable, SerializesModels;

  public $student;
  public $courseEvent;
  public $courseEventStudent;

  /**
   * Create a new event instance.
   * 
   * @param Student $student
   * @param CourseEvent $courseEvent
   * @param String $token
   * @return void
   */
  public function __construct(Student $student, CourseEventStudent $courseEventStudent, CourseEvent $courseEvent)
  {
    $this->student = $student;
    $this->courseEvent = $courseEvent;
    $this->courseEventStudent = $courseEventStudent;
  }
}
