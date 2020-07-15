<?php
namespace App\Listeners;
use App\Events\StudentRegistered;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailVerification
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  /**
   * Handle the event.
   *
   * @param  StudentRegistered  $event
   * @return void
   */
  public function handle(StudentRegistered $event)
  {
    $user = $event->user;
    $user_data = $event->user_data;
    
    Mail::to($user->email)
          ->cc([\Config::get('sipt.email_cc')])
          ->send(
              new EmailVerification(
                [
                  'user' => $user,
                  'user_data' => $user_data
                ]
          )
    );
  }
}
