<?php
namespace App\Listeners;
use App\Services\Document;
use App\Events\CourseEventInvitation;
use App\Models\CourseEvent;
use App\Models\CourseEventStudent;
use App\Models\Student;
use App\Mail\CourseEventInvitationNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CourseEventCreateSendInvitation
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct(Student $student, CourseEvent $courseEvent, CourseEventStudent $courseEventStudent)
  {
    $this->student = $student;
    $this->courseEvent = $courseEvent;
    $this->courseEventStudent = $courseEventStudent;
  }

  /**
   * Handle the event.
   *
   * @param  CourseEventInvitation $event
   * @return void
   */
  public function handle(CourseEventInvitation $event)
  {
    // Get callable courses with billableStudents
    $courseEvents = $this->courseEvent->with('course', 'dates', 'location', 'callableStudents')->callable();

    // Filter out empty course events without students
    $courseEventsWithStudents = $courseEvents->filter(function($courseEvent) {
      return $courseEvent->callableStudents->count() > 0;
    });
   
    if ($courseEventsWithStudents->count())
    {    
      // Loop over all events  
      foreach($courseEventsWithStudents as $courseEvent)
      {
        // Build chunk
        $students = collect($courseEvent->callableStudents)->splice(0, \Config::get('sipt.cron_chunk_size'));

        // Loop over all students
        foreach($students->all() as $student)
        {
          // Get student data
          $student = $this->student->with('user')->find($student->id);

          // Get course_event_student data
          $courseEventStudent = $this->courseEventStudent->where('student_id', '=', $student->id)->where('course_event_id', '=', $courseEvent->id)->get()->first();

          if ($courseEventStudent->is_invited === 0)
          {
            // Update confirmation state
            $courseEventStudent->is_invited = 1;
            $courseEventStudent->save();

            // Notify student
            $this->notify($courseEvent, $student);
          }
        }
      }
    }
  }

  /**
   * Send mail to student
   * 
   * @param $invoice
   * @return void
   */
  public function notify($courseEvent, $student)
  {
    $document = new Document();
    $document = $document->invitation($courseEvent, $student);
    
    // Prepare attachements
    $attachments = [
      isset($document['path']) ? $document['path'] : null,
      public_path() . '/storage/downloads/' . 'sipt-kursbeurteilung.pdf',
    ];

    $hasMap = false;
    if ($courseEvent->location->maps_file && !$courseEvent->is_online)
    {
      $attachments[] =  public_path() . '/storage/downloads/' . $courseEvent->location->maps_file;
      $hasMap = true;
    }

    Mail::to($student->user->email)
          ->bcc(\Config::get('sipt.email_copy'))
          ->send(
              new CourseEventInvitationNotification(
                [
                  'student' => $student,
                  'courseEvent' => $courseEvent,
                  'attachments' => $attachments,
                  'hasMap' => $hasMap
                ]
              )
    );
  }
}
