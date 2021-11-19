<?php
namespace App\Listeners;
use App\Events\TutorStored;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailVerificationTutor
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
   * @param  TutorStored  $event
   * @return void
   */
  public function handle(TutorStored $event)
  {
    $user = $event->user;
    $user_data = $event->user_data;
    
    Mail::to($user->email)
          ->bcc(\Config::get('sipt.email_copy'))
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
