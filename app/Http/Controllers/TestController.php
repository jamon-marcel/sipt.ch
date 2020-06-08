<?php
namespace App\Http\Controllers;
use App\Models\Course;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\StudentStoreRequest;
use Illuminate\Http\Request;

class TestController extends Controller
{
  public function __construct(Course $course, Student $student)
  {
    $this->course = $course;
    $this->student = $student;
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
}
