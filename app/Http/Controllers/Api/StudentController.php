<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\Student;
use App\Models\CourseEventStudent;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentStoreEventCourseRequest;
use Illuminate\Http\Request;

class StudentController extends Controller
{
  public function __construct(Student $student)
  {
    $this->student = $student;
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
   * Get current student
   * 
   * @param Student $student
   * @return \Illuminate\Http\Response
   */
  public function show(Student $student)
  {
    return response()->json($this->student->with('user')->find($student->id));
  }

  /**
   * Edit current student
   * 
   * @param Student $student
   * @return \Illuminate\Http\Response
   */
  public function edit(Student $student)
  {
    return response()->json($this->student->with('user')->find($student->id));
  }

  /**
   * Update the current student
   *
   * @param Student $student
   * @param  \Illuminate\Http\Request $request
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
    $data = $this->student->with('courseEvents.dates')
                          ->with('courseEvents.course')
                          ->find($student->id);
    return response()->json($data);
  }

  /**
   * Add course events for a student
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function updateCourseEvents(StudentStoreEventCourseRequest $request)
  {
    $student = $this->student->findOrFail($request->id);
    if ($request->course_events)
    {
      $student->courseEvents()->detach();
      foreach($request->course_events as $course)
      { 
        $course_event = new CourseEventStudent([
          'course_event_id' => $course['id'],
          'student_id' => $request->id
        ]);
        $course_event->save();
      }
    }
    return response()->json('successfully updated');
  }
}
