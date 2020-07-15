<?php
namespace App\Events;
use App\Models\Student;
use App\Models\CourseEvent;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StudentInvoice
{
  use Dispatchable, SerializesModels;

  public $student;
  public $courseEvent;
  
  /**
   * Create a new event instance.
   * @param Student $student
   * @param CourseEvent $courseEvent
   * @return void
   */
  public function __construct(Student $student, CourseEvent $courseEvent)
  {
    $this->student = $student;
    $this->courseEvent = $courseEvent;
  }
}
