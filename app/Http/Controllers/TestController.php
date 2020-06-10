<?php
namespace App\Http\Controllers;
use App\Models\Course;
use App\Models\CourseEvent;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\StudentStoreRequest;
use Illuminate\Http\Request;

class TestController extends Controller
{
  public function __construct(Course $course, Student $student, CourseEvent $courseEvent)
  {
    $this->course = $course;
    $this->student = $student;
    $this->courseEvent = $courseEvent;
  }

  public function course(Course $course)
  {

  }

  public function register()
  {
    return view('frontend.register');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StudentStoreRequest $request)
  {
    $user = User::create([
      'email' => $request->input('email'),
      'password' => Hash::make(Str::random(16)),
      'role' => 'student'
    ]);
    $student = Student::create(array_merge($request->except('email'), ['user_id' => $user->id]));
  }

  public function student(Student $student)
  {

  }

  public function courses()
  {
    //$courses = $this->course->with('events.dates')->get();

    $courses = $this->course->join('course_events', 'courses.id', '=', 'course_events.course_id')
                            ->leftJoin('locations', 'course_events.location_id', '=', 'locations.id')
                            ->join('course_event_dates', 'course_events.id', '=', 'course_event_dates.course_event_id')
                            ->join('tutors', 'tutors.id', '=', 'course_event_dates.tutor_id')
                            ->orderBy('course_event_dates.date', 'ASC')
                            ->select('course_event_dates.date', 'tutors.name', 'tutors.firstname', 'locations.name_short', 'locations.city', 'course_events.id as courseEventId')
                            ->where('courses.id', '=', '22b3320b-c4c4-4e9e-8a07-bd58f8ff5ebd')
                            ->get();

    $collection = collect($courses);
    dd($collection->groupBy('courseEventId'));

  }
}
