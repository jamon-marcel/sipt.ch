<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\Course;
use App\Models\CourseEvent;
use App\Models\CourseEventStudent;
use App\Models\Invoice;
use App\Models\Student;
use App\Events\CourseEventParticipantsChanged;
use App\Events\CourseEventCancelled;
use App\Events\InvoiceReminder;
use App\Events\CourseEventClosed;
use App\Services\CourseInvoice;
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
    $courses = $this->course->with('eventsCompleted.dates.tutor', 'eventsCompleted.location')->orderBy('number')->get();
    return new DataCollection($courses);
  }

  /**
   * Get a list of past and closed courses with events
   * 
   * @param Course $course
   * @return \Illuminate\Http\Response
   */
  public function getClosedCourses()
  {
    $courses = $this->course->with('eventsClosed.dates.tutor', 'eventsClosed.location')->orderBy('number')->get();
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
    $courseEvent = $this->courseEvent->with('course', 'location', 'activeInvoices.student', 'dates.tutor', 'students')->find($courseEvent->id);
    return response()->json($courseEvent);
  }

  /**
   * Get a course events for a given course number
   *
   * @param string $number
   * @return \Illuminate\Http\Response
   */
  public function getCourseByNumber($number = NULL)
  {
    $courses = $this->course->with('events')->where('number', '=', $number)->get()->first();
    return response()->json($courses);
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

  /**
   * Create a booking for a student
   * 
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function import(Request $request)
  {
    // Create Course Event
    $course_event = CourseEventStudent::firstOrNew(
      ['course_event_id' => $request->courseEventId, 'student_id' => $request->studentId],
      [
        'course_event_id' => $request->courseEventId,
        'student_id' => $request->studentId,
        'booking_number' => $request->booking,
        'created_at' => $request->date
      ]
    );
    $course_event->save();

    // Check max. participants
    event(new CourseEventParticipantsChanged($courseEvent));

    return response()->json(true);                                           

  }

  /**
   * Get all bookings for a given student
   * 
   * @param Student $student
   * @return \Illuminate\Http\Response
   */

  public function getBookings(Student $student)
  {
    $bookings = $student->courseEvents()
                        ->with('course', 'location', 'dates.tutor')
                        ->where('course_event_student.is_billed', '=', 0)
                        ->where('course_event_student.deleted_at', '=', NULL)
                        ->get();

    return response()->json($bookings);
  }

  /**
   * Create an invoice
   * 
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */

  public function createInvoice(Request $request)
  {
    $student     = $this->student->findOrFail($request->studentId);
    $courseEvent = $this->courseEvent->with('course', 'dates')->findOrFail($request->courseEventId);

    $courseInvoice = new CourseInvoice();
    $courseInvoice->create([
      'date'  => $request->date ? $request->date : date('d.m.Y', time()),
      'amount' => $request->amount,
      'number' => $request->number,
      'client' => $student,
      'booking_number' => $request->booking_number,
      'course_event' => $courseEvent,
    ]);
          
    // Write to disk
    $file = $courseInvoice->write();

    // Store in database
    $invoice = $courseInvoice->store();

    return response()->json($file);
  }

  /**
   * Remove a course event for given student or an authenticated user
   *
   * @param CourseEvent $courseEvent
   * @param Student $student
   * @return \Illuminate\Http\Response
   */
  public function destroyCourseEventStudent(CourseEvent $courseEvent, Student $student)
  {
    $student = $this->student->findOrFail($student->id);

    // Get record
    $courseEventStudent = $this->courseEventStudent->where('course_event_id', '=', $courseEvent->id)
                                                   ->where('student_id', '=', $student->id)
                                                   ->firstOrFail();
    // Confirm cancellation
    event(new CourseEventCancelled($student, $courseEventStudent, $courseEvent));

    // Check max. participants
    event(new CourseEventParticipantsChanged($courseEvent));

    return response()->json('successfully removed');
  }

  /**
   * Add a course event for given student and course event
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function addCourseEventStudent(Request $request)
  {
    // 
    $studentId = $request->studentId;
    $courseEventId = $request->courseEventId;

    // Create entry for course event student
    $course_event_student = CourseEventStudent::create(
      [
        'course_event_id' => $request->courseEventId,
        'student_id' => $request->studentId,
        'booking_number' => \BookingHelper::getNumber(),
        'has_confirmation' => 0,
        'is_invited' => 1,
        'has_attendance' => 1
      ]
    );
    $course_event_student->save();
    return response()->json('successfully added');
  }

}
