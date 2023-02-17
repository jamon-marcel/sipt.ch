<?php
namespace App\Actions\Mailinglist;
use App\Models\MailinglistSubscriber;
use App\Models\Mailinglist;
use App\Actions\Mailinglist\ActivateSubscriber;
use App\Actions\Mailinglist\CreateSubscriber;
use App\Actions\Mailinglist\SendEmailConfirmation;

class RegisterSubscriber
{
  public function __construct(
    ActivateSubscriber $activateSubscriber, 
    CreateSubscriber $createSubscriber, 
    SendEmailConfirmation $sendEmailConfirmation)
  {
    $this->activateSubscriber = $activateSubscriber;
    $this->createSubscriber = $createSubscriber;
    $this->sendEmailConfirmation = $sendEmailConfirmation;
  }

  public function execute($mailinglists = [], $email, $isConfirmed = FALSE)
  {
    $mustConfirmEmail = TRUE;
    foreach($mailinglists as $mailinglist)
    {
      $subscriber = MailinglistSubscriber::withTrashed()->where('email', $email)->where('mailinglist_id', $mailinglist)->first();
      if ($subscriber)
      {
        $this->activateSubscriber->execute($subscriber, $isConfirmed);
        $mustConfirmEmail = $subscriber->is_confirmed ? FALSE : TRUE;
      }
      else
      {
        $subscriber = $this->createSubscriber->execute([
          'mailinglist' => Mailinglist::find($mailinglist),
          'email' => $email
        ], $isConfirmed);
      }
    }

    if ($mustConfirmEmail && $isConfirmed === FALSE)
    {
      $this->sendEmailConfirmation->execute($subscriber);
    }
    
    return TRUE;
  }
}