<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\User;
use App\Models\Student;
use App\Models\CourseEvent;
use App\Models\CourseEventStudent;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentStoreEventCourseRequest;
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
    return new DataCollection($this->student->get());
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
                                ->take($limit)
                                ->get();
      break;

      // Booked events
      case 'booked':
        $courseEvents = $student->courseEvents()
                                ->with('course', 'location', 'dates.tutor')
                                ->where('has_attendance', '=', 0)
                                ->get();
      break;

      // Attended events
      case 'attended':
        $courseEvents = $student->courseEvents()
                                ->with('course', 'location', 'dates.tutor')
                                ->where('has_attendance', '=', 1)
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
                ? $this->student->findOrFail($student->id)
                : $this->student->authenticated(auth()->user()->id);

    // Create Course Event
    $course_event = new CourseEventStudent([
      'course_event_id' => $request->courseEventId,
      'student_id' => $student->id
    ]);
    $course_event->save();
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

    $student->courseEvents()->detach($courseEvent->id);
  
    return response()->json('successfully removed');
  }
}
