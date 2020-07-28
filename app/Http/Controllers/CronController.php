<?php
namespace App\Http\Controllers;
use App\Models\CourseEvent;
use App\Events\CourseEventBill;

// Invitation
use App\Models\Tutor;
use App\Models\Student;
use App\Models\User;
use App\Mail\InvitationTutorNotification;
use App\Mail\InvitationStudentNotification;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class CronController extends BaseController
{
  public function __construct(CourseEvent $courseEvent)
  {
    parent::__construct();
    $this->courseEvent = $courseEvent;
  }

  // public function billable()
  // {
  //   // Get billable courses with billableStudents
  //   $courseEvents = $this->courseEvent->with('course', 'dates', 'billableStudents')->billable();

  //   // Filter out empty 'billableStudents' relationships
  //   $courseEventsWithStudents = $courseEvents->filter(function($courseEvent) {
  //     return $courseEvent->billableStudents->count() > 0;
  //   });

  //   if ($courseEventsWithStudents->count())
  //   {
  //     foreach($courseEventsWithStudents as $courseEvent)
  //     {
  //       foreach($courseEvent->billableStudents as $student)
  //       {
  //         event(new CourseEventBill($student, $courseEvent));
  //       }
  //     }
  //   }
  // }

  // public function inviteTutors()
  // {
  //   $tutors = User::with('tutor')->where('has_invitation', '=', 0)->where('role', '=', 'tutor')->get();
  //   Mail::to('marcel.stadelmann@gmail.com')
  //         ->cc(\Config::get('sipt.email_cc'))
  //         ->send(
  //             new InvitationTutorNotification(
  //               [
  //                 'tutor' => $tutors[0],
  //               ]
  //         )
  //   );

  // }

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
}
