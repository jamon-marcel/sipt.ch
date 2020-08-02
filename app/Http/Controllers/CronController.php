<?php
namespace App\Http\Controllers;

// Onboarding
use App\Models\Tutor;
use App\Models\Student;
use App\Models\User;
use App\Mail\InvitationTutorNotification;
use App\Mail\InvitationStudentNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class CronController extends Controller
{
  public function __construct()
  {

  }

  public function invitations()
  {
    // event(new \App\Events\CourseEventInvitation());
  }

  public function bills()
  {
    // event(new \App\Events\CourseEventBill(TRUE));
  }


  // public function inviteStudents()
  // {
  //   $students = User::with('student')->where('has_invitation', '=', 0)->where('role', '=', 'student')->get();
    

  //   // foreach($students as $s)
  //   // {
  //   //   // send mail
  //   //   $pw = \Str::random(16);


  //   //   // Hash::make($pw)
      
  //   // }

  
  //   $pw = \Str::random(16);
  //   Mail::to('marcel.stadelmann@gmail.com')
  //       ->cc(\Config::get('sipt.email_cc'))
  //       ->send(
  //           new InvitationStudentNotification(
  //             [
  //               'student'  => $students[0],
  //               'email'    => $students[0]->email,
  //               'password' => $pw,
  //             ]
  //       )
  //   );
  // }

  // $user->markEmailAsVerified();
}
