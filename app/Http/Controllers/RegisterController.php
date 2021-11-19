<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\StudentStoreRequest;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
  public function __construct(User $user)
  {
    $this->user = $user;
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
    $pw   = Str::random(16);
    $user = User::create([
      'email' => $request->input('email'),
      'password' => Hash::make($pw),
      'role' => 'student'
    ]);
    $student = Student::create(array_merge($request->except('email'), ['user_id' => $user->id]));
  }
} 
