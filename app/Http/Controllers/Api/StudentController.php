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
   * Get all students
   * 
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return new DataCollection($this->student->get());
  }

  /**
   * Show the current student
   * 
   * @param Student $student
   * @return \Illuminate\Http\Response
   */
  public function show(Student $student)
  {
    return response()->json($this->student->with('user')->find($student->id));
  }

  /**
   * Edit the current student
   * 
   * @param Student $student
   * @return \Illuminate\Http\Response
   */
  public function edit(Student $student)
  {
    $student = $this->student->with('user')
                             ->where('user_id', '=', auth()->user()->id)
                             ->get()
                             ->first();

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
    $student->update($request->all());
    $student->save();
    return response()->json('successfully updated');
  }

  /**
   * Get student by id with course events
   *
   * @param Student $student
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function courses(Student $student)
  {
    $data = $this->student->with('user')
                          ->with('courseEvents.dates')
                          ->with('courseEvents.course')
                          ->find($student->id);
    return response()->json($data);
  }

  /**
   * Add a course event for given student (admin) or authenticated user
   *
   * @param Student $student
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */

  public function storeCourseEvent(StudentStoreCourseEventRequest $request, Student $student)
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
   * Remove a course event for given student (admin) or authenticated user
   *
   * @param CourseEvent $courseEvent
   * @param Student $student
   * @return \Illuminate\Http\Response
   */

  public function destroyCourseEvent(CourseEvent $courseEvent, Student $student)
  {
    // Get student
    $student = auth()->user()->isAdmin()
              ? $this->student->findOrFail($student->id)
              : $this->student->authenticated(auth()->user()->id);

    $student->courseEvents()->detach($courseEvent->id);
    return response()->json('successfully removed');
  }

  /**
   * Get a students profile by given student (admin) or by authenticated user
   *
   * @param Student $student
   * @return \Illuminate\Http\Response
   */
  public function profile(Student $student)
  {
    // Get profile
    $profile = auth()->user()->isAdmin()
                ? $this->student->with('user')->findOrFail($student->id)
                : $this->student->with('user')->authenticated(auth()->user()->id);
    return response()->json($profile);
  }

  /**
   * Get a students upcoming courseEvents
   * 
   * @return \Illuminate\Http\Response
   */
  public function upcomingCourses($limit = 1)
  {
    // Get student by logged in user
    $student = $this->student->authenticated(auth()->user()->id);

    // Get courseEvents with all related data
    $courseEvents = $student->courseEvents('upcoming')
                            ->take($limit)
                            ->with('course')
                            ->with('location')
                            ->with('dates.tutor')
                            ->get();

    return response()->json(['student' => $student, 'courseEvents' => $courseEvents]);
  }

  /**
   * Get a students booked courses by given student (admin) or by authenticated user
   *
   * @param Student $student
   * @return \Illuminate\Http\Response
   */
  public function bookedCourses(Student $student)
  {
    // Get student
    $student = auth()->user()->isAdmin()
                ? $this->student->findOrFail($student->id)
                : $this->student->authenticated(auth()->user()->id);

    // Get courseEvents with all related data
    $courseEvents = $student->courseEvents()
                            ->with('course')
                            ->with('location')
                            ->with('dates.tutor')
                            ->where('has_attendance', '=', 0)
                            ->get();

    return response()->json(['courseEvents' => $courseEvents]);
  }

  /**
   * Get a students attended courses by given student (admin) or by authenticated user
   *
   * @param Student $student
   * @return \Illuminate\Http\Response
   */
  public function attendedCourses(Student $student)
  {
    // Get student
    $student = auth()->user()->isAdmin()
                ? $this->student->findOrFail($student->id)
                : $this->student->authenticated(auth()->user()->id);

    // Get courseEvents with all related data
    $courseEvents = $student->courseEvents()
                            ->with('course')
                            ->with('location')
                            ->with('dates.tutor')
                            ->where('has_attendance', '=', 1)
                            ->get();

    return response()->json(['courseEvents' => $courseEvents]);
  }

  /**
   * Get a single courseEvent for a student
   *
   * @param CourseEvent $courseEvent
   * @return \Illuminate\Http\Response
   */

  public function course(CourseEvent $courseEvent)
  { 
    // Get student by logged in user
    $student = $this->student->authenticated(auth()->user()->id);

    // Get courseEvent with all related data
    $courseEvent = $student->courseEvents()
                           ->with('course')
                           ->with('location')
                           ->with('dates.tutor')
                           ->find($courseEvent->id);

    return response()->json($courseEvent);
  }
}
