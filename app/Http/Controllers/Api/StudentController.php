<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\User;
use App\Models\Student;
use App\Models\CourseEvent;
use App\Models\CourseEventStudent;
use App\Events\CourseEventBooked;
use App\Events\CourseEventParticipantsChanged;
use App\Events\CourseEventCancelled;
use App\Events\CourseEventCancelledWithPenalty;
use App\Services\Withdrawal;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentStoreCourseEventRequest;
use Illuminate\Http\Request;

class StudentController extends Controller
{
  public function __construct(
    Student $student, 
    CourseEvent $courseEvent,
    CourseEventStudent $courseEventStudent)
  {
    $this->student = $student;
    $this->courseEvent = $courseEvent;
    $this->courseEventStudent = $courseEventStudent;
    $this->authorizeResource(Student::class, 'student');
  }

  /**
   * Get a list of students
   * 
   * @return \Illuminate\Http\Response
   */
  public function get()
  {
    return new DataCollection($this->student->with('user')->orderBy('name')->get());
  }

  /**
   * Get a single student for a given student or an authenticated student
   * 
   * @param Student $student
   * @return \Illuminate\Http\Response
   */
  public function find(Student $student)
  {
    $student = auth()->user()->isAdmin()
                ? $this->student->with('user')->findOrFail($student->id)
                : $this->student->with('user')->authenticated(auth()->user()->id);

    return response()->json($student);
  }

  /**
   * Update the current student
   *
   * @param Student $student
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function update(Student $student, StudentStoreRequest $request)
  {
    $student->update($request->except('user.email'));
    $student->save();
    return response()->json('successfully updated');
  }

  /**
   * Get course events for a given student or an authenticated student with constraints
   * 
   * @param String $type
   * @param Integer $limit
   * @param Student $student
   * @return \Illuminate\Http\Response
   */
  public function getEvents($type = NULL, $limit = 1, Student $student)
  {
    // Get student by logged in user
    $student = auth()->user()->isAdmin()
                ? $this->student->with('user')->findOrFail($student->id)
                : $this->student->with('user')->authenticated(auth()->user()->id);

    // Get events by type
    switch($type)
    {
      // Upcoming events
      case 'upcoming':
        $courseEvents = $student->courseEvents('upcoming')
                                ->with('course', 'location', 'dates.tutor')
                                ->where('course_event_student.deleted_at', '=', NULL)
                                ->take($limit)
                                ->get();
      break;

      // Booked events
      case 'booked':
        $courseEvents = $student->courseEvents('booked')
                                ->with('course', 'location', 'dates.tutor')
                                ->where('has_attendance', '=', 0)
                                ->where('course_event_student.deleted_at', '=', NULL)
                                ->get();
      break;

      // Attended events
      case 'attended':
        $courseEvents = $student->courseEvents()
                                ->with('course', 'location', 'dates.tutor')
                                ->where('has_attendance', '=', 1)
                                ->where('course_event_student.deleted_at', '=', NULL)
                                ->get();
      break;

      // All events
      default:
        $courseEvents = $student->courseEvents()->with('course', 'location', 'dates.tutor')->get();
      break;
    }

    return response()->json(['student' => $student, 'courseEvents' => $courseEvents]);
  }

  /**
   * Get a course event for a given student or an authenticated student
   *
   * @param CourseEvent $courseEvent
   * @param Student $student
   * @return \Illuminate\Http\Response
   */
  public function getEvent(CourseEvent $courseEvent, Student $student)
  { 
    // Get student by logged in user
    $student = auth()->user()->isAdmin()
                ? $this->student->with('user')->findOrFail($student->id)
                : $this->student->with('user')->authenticated(auth()->user()->id);

    // Get courseEvent with all related data
    $courseEvent = $student->courseEvents()
                           ->with('course', 'location', 'dates.tutor', 'documents')
                           ->find($courseEvent->id);

    return response()->json($courseEvent);
  }

  /**
   * Store a course event for given student or an authenticated user
   *
   * @param Student $student
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */

  public function storeEvent(StudentStoreCourseEventRequest $request, Student $student)
  {
    // Get student
    $student = auth()->user()->isAdmin()
                ? $this->student->with('user')->findOrFail($student->id)
                : $this->student->with('user')->authenticated(auth()->user()->id);

    // Create Course Event
    $course_event = CourseEventStudent::firstOrNew(
      ['course_event_id' => $request->courseEventId, 'student_id' => $student->id],
      [
        'course_event_id' => $request->courseEventId,
        'student_id' => $student->id,
        'booking_number' => \BookingHelper::getNumber()
      ]
    );
    $course_event->save();

    // Get course event data for confirmation
    $courseEvent = $this->courseEvent->with('course', 'dates')->find($request->courseEventId);

    // Send confirmation
    event(new CourseEventBooked($student, $courseEvent));

    // Check max. participants
    event(new CourseEventParticipantsChanged($courseEvent));

    return response()->json('successfully stored');
  }

  /**
   * Remove a course event for given student or an authenticated user
   *
   * @param CourseEvent $courseEvent
   * @param Student $student
   * @return \Illuminate\Http\Response
   */
  public function destroyEvent(CourseEvent $courseEvent, Student $student)
  {
    $student = auth()->user()->isAdmin()
                ? $this->student->findOrFail($student->id)
                : $this->student->authenticated(auth()->user()->id);

    // Get record
    $courseEventStudent = $this->courseEventStudent->where('course_event_id', '=', $courseEvent->id)
                                                   ->where('student_id', '=', $student->id)
                                                   ->firstOrFail();

    // Get withdrawal penalty
    $withdrawal = new Withdrawal();
    $penalty    = $withdrawal->getCharges($courseEvent->dateStart);

    // If there is no penalty set cancellation date and delete entry
    if ($penalty == 0)
    {
      // Confirm cancellation
      event(new CourseEventCancelled($student, $courseEventStudent, $courseEvent));
    }
    else
    {
      // Confirm cancellation
      event(new CourseEventCancelledWithPenalty($student, $courseEventStudent, $courseEvent, $penalty));
    }

    // Check max. participants
    event(new CourseEventParticipantsChanged($courseEvent));

    return response()->json('successfully removed');
  }
}
