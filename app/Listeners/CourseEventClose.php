<?php
namespace App\Listeners;
use App\Services\Document;
use App\Events\CourseEventClosed;
use App\Mail\CourseEventAttendanceConfirmation;
use App\Models\CourseEvent;
use App\Models\CourseEventStudent;
use App\Models\Student;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CourseEventClose
{
  /**
   * Create the event listener.
   *
   * @param CourseEvent $courseEvent
   * @return void
   */
  public function __construct(CourseEvent $courseEvent, Student $student, CourseEventStudent $courseEventStudent)
  {
    $this->courseEvent        = $courseEvent;
    $this->courseEventStudent = $courseEventStudent;
    $this->student            = $student;
  }

  /**
   * Handle the event.
   *
   * @param  CourseEventClosed $event
   * @return void
   */
  public function handle(CourseEventClosed $event)
  {
    $courseEvent = $this->courseEvent->with('course', 'location', 'dates.tutor', 'students')->find($event->courseEvent->id);
    
    if ($courseEvent->students)
    {
      foreach($courseEvent->students as $student)
      {
        // Get student data
        $student = $this->student->with('user')->find($student->id);
        
        // Get course_event_student data
        $courseEventStudent = $this->courseEventStudent->where('student_id', '=', $student->id)
                                                       ->where('course_event_id', '=', $courseEvent->id)
                                                       ->get()
                                                       ->first();

        if ($courseEventStudent->has_attendance === 1 && $courseEventStudent->has_confirmation === 0)
        {
          // Update confirmation state
          $courseEventStudent->has_confirmation = 1;
          $courseEventStudent->save();

          // Notify student
          $this->notify($courseEvent, $student);
        }
      }
    }
  }

  /**
   * Send mail to student
   * 
   * @param $courseEvent
   * @param $student
   */

  public function notify($courseEvent, $student)
  {
    $document = new Document();
    $document = $document->attendance($courseEvent, $student);

    Mail::to($student->user->email)
        ->cc(\Config::get('sipt.email_cc'))
        ->send(
            new CourseEventAttendanceConfirmation(
              [
                'student' => $student,
                'courseEvent' => $courseEvent,
                'pdf' => isset($document['path']) ? $document['path'] : null
              ]
        )
    );
  }
}
