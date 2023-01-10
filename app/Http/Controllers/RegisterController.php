<?php
namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Models\Student;
use App\Events\StudentRegistered;
use App\Actions\Mailinglist\RegisterSubscriber;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\StudentRegisterRequest;
use Illuminate\Http\Request;

class RegisterController extends BaseController
{
  protected $viewPath = 'web.pages.register.';
 
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    return view($this->viewPath . 'index');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StudentRegisterRequest $request, RegisterSubscriber $registerSubscriber)
  {
    $pw   = Str::random(16);
    $user = User::create([
      'email' => $request->input('email'),
      'password' => Hash::make($pw),
      'role' => 'student'
    ]);

    // Create Student
    $student_number = Student::max('number') + 1;
    $student = Student::create(array_merge($request->except('email'), ['user_id' => $user->id, 'number' => $student_number]));

    // Get the student
    $student = Student::with('user')->find($student->id);

    // Fire registered event
    event(new StudentRegistered($user, ['password' => $pw]));

    // Handle mailinglist subscriptions
    $registerSubscriber->execute(
      $request->input('mailinglists'), 
      $request->input('email')
    );

    return redirect()->route('register_done');
  }

  public function registered()
  {
    return view($this->viewPath . 'registered');
  }
} 
