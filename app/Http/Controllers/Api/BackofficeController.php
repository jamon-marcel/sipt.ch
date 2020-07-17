<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\Course;
use App\Models\CourseEvent;
use App\Models\CourseEventStudent;
use App\Models\Invoice;
use App\Models\Student;
use App\Events\InvoiceReminder;
use Illuminate\Http\Request;

class BackofficeController extends Controller
{
  public function __construct(
    Course $course, 
    CourseEvent $courseEvent,
    CourseEventStudent $courseEventStudent,
    Student $student,
    Invoice $invoice
  )
  {
    $this->course             = $course;
    $this->courseEvent        = $courseEvent;
    $this->courseEventStudent = $courseEventStudent;
    $this->student            = $student;
    $this->invoice            = $invoice;
  }

  /**
   * Get a list of past courses with events
   * 
   * @param Course $course
   * @return \Illuminate\Http\Response
   */
  public function getConcludedCourses()
  {
    $courses = $this->course->with('eventsCompleted.dates.tutor', 'eventsCompleted.location')->get();
    return new DataCollection($courses);
  }

  /**
   * Get a course event for a given course event
   *
   * @param CourseEvent $courseEvent
   * @return \Illuminate\Http\Response
   */
  public function getCourseEvent(CourseEvent $courseEvent)
  {
    $courseEvent = $this->courseEvent->with('course', 'location', 'invoices.student', 'dates.tutor', 'students')->find($courseEvent->id);
    return response()->json($courseEvent);
  }

  /**
   * Set attendance for a given student
   * 
   * @param Student $student
   * @param CourseEvent $courseEvent
   * @return \Illuminate\Http\Response
   */
  public function setAttendance(Student $student, CourseEvent $courseEvent)
  {
    $course_event_student = $this->courseEventStudent->where('student_id', '=', $student->id)
                                                     ->where('course_event_id', '=', $courseEvent->id)
                                                     ->get()
                                                     ->first();

    $course_event_student->has_attendance = $course_event_student->has_attendance == 0 ? 1 : 0;
    $course_event_student->save();
    return response()->json($course_event_student->has_attendance);                                           
  }

}
