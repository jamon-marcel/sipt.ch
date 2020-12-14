<?php
namespace App\Listeners;
use App\Events\CourseEventCancelledByAdministrator;
use App\Mail\CourseEventCancelByAdministratorStudentNotification;
use App\Mail\CourseEventCancelByAdministratorTutorNotification;
use App\Models\CourseEvent;
use App\Models\CourseEventStudent;
use App\Models\Student;
use App\Models\Tutor;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CourseEventCancelByAdministrator
{
  /**
   * Create the event listener.
   *
   * @param CourseEvent $courseEvent
   * @return void
   */
  public function __construct(CourseEvent $courseEvent, Student $student, Tutor $tutor, CourseEventStudent $courseEventStudent)
  {
    $this->courseEvent        = $courseEvent;
    $this->courseEventStudent = $courseEventStudent;
    $this->student            = $student;
    $this->tutor              = $tutor;
  }

  /**
   * Handle the event.
   *
   * @param  CourseEventCancelledByAdministrator  $event
   * @return void
   */
  public function handle(CourseEventCancelledByAdministrator $event)
  {
    $courseEvent = $this->courseEvent->with('course', 'location', 'dates.tutor', 'students')->find($event->courseEvent->id);

    // Send notification to Students
    if ($courseEvent->students)
    {
      foreach($courseEvent->students as $student)
      {
        $student = $this->student->with('user')->find($student->id);
        
        $courseEventStudent = $this->courseEventStudent->where('student_id', '=', $student->id)
                                                       ->where('course_event_id', '=', $courseEvent->id)
                                                       ->where('is_cancelled', '=', 0)
                                                       ->get()
                                                       ->first();

        if ($courseEventStudent)
        {
          $courseEventStudent->is_cancelled = 1;
          $courseEventStudent->cancelled_at = date('d.m.Y', time());
          $courseEventStudent->save();
          $courseEventStudent->delete();

          Mail::to($student->user->email)
              ->bcc(\Config::get('sipt.email_copy'))
              ->send(
                  new CourseEventCancelByAdministratorStudentNotification(
                    [
                      'student' => $student,
                      'courseEvent' => $courseEvent,
                    ]
              )
          );
        }                                            
      }
    }

    // Send notification to Tutors
    if ($courseEvent->dates)
    {
      foreach($courseEvent->dates as $date)
      {
        if ($date->tutor)
        {
          $tutor = $this->tutor->with('user')->find($date->tutor->id);
          Mail::to($tutor->user->email)
                ->bcc(\Config::get('sipt.email_copy'))
                ->send(
                    new CourseEventCancelByAdministratorTutorNotification(
                      [
                        'tutor' => $tutor,
                        'courseEvent' => $courseEvent,
                      ]
                )
          );
        }
      }
    }
  }
}
