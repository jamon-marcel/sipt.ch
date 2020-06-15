<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Tutor;
use App\Models\Administrator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserChangeEmailRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function __construct(User $user, Student $student, Tutor $tutor, Administrator $administrator)
  {
    $this->user = $user;
    $this->student = $student;
    $this->tutor = $tutor;
    $this->administrator = $administrator;
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */

  public function register(UserRegisterRequest $request)
  {
    $user = User::create([
      'email' => $request->input('email'),
      'password' => Hash::make(Str::random(16)),
      'role' => 'tutor'
    ]);
    return response()->json(['userId' => $user->id]);
  }

  /**
   * Get a students info by its user
   */
  public function student()
  {
    $student = $this->student->with('user')
                             ->where('user_id', '=', auth()->user()->id)
                             ->first();
    return response()->json(['firstname' => $student->firstname, 'name' => $student->name]);
  }

  /**
   * Get a administrators info by its user
   */
  public function admin()
  {
    $administrator = $this->administrator->with('user')
                                         ->where('user_id', '=', auth()->user()->id)
                                         ->first();
    return response()->json(['firstname' => $administrator->firstname, 'name' => $administrator->name]);
  }

  /**
   * Change a users email address
   * 
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function updateEmail(UserChangeEmailRequest $request)
  {
    $user = $this->user->findOrFail(auth()->user()->id);
    $user->email = $request->email;
    $user->email_verified_at = null;
    $user->sendEmailVerificationNotification();
    $user->save();
    return response()->json('successfully updated');
  }

}
