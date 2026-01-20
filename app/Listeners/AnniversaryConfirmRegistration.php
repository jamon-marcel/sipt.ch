<?php
namespace App\Listeners;
use App\Events\AnniversaryRegistration;
use App\Mail\AnniversaryRegistrationConfirmation;
use App\Mail\AnniversaryRegistrationNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AnniversaryConfirmRegistration
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
   * @param  AnniversaryRegistration  $event
   * @return void
   */
  public function handle(AnniversaryRegistration $event)
  {
    $registration = $event->registration;

    // Send confirmation to registrant
    Mail::to($registration->email)
          ->bcc(\Config::get('sipt.email_copy'))
          ->send(
              new AnniversaryRegistrationConfirmation([
                'registration' => $registration,
              ])
          );

    // Send notification to business owner
    $ownerEmail = \Config::get('sipt.anniversary_notification_email', \Config::get('sipt.email_copy'));
    if ($ownerEmail) {
      Mail::to($ownerEmail)
            ->send(
                new AnniversaryRegistrationNotification([
                  'registration' => $registration,
                ])
            );
    }
  }
}
