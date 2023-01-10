<?php
namespace App\Actions\Mailinglist;
use App\Models\Mailinglist;
use App\Models\MailinglistSubscriber;
use App\Actions\Mailinglist\ActivateSubscriber;
use App\Actions\Mailinglist\CreateSubscriber;

class CreateOrUpdateSubscriber
{
  public function __construct(ActivateSubscriber $activateSubscriber, CreateSubscriber $createSubscriber)
  {
    $this->activateSubscriber = $activateSubscriber;
    $this->createSubscriber = $createSubscriber;
  }

  public function execute($data)
  {
    $subscription = MailinglistSubscriber::withTrashed()->where('mailinglist_id', $data['mailinglist']->id)->where('email', $data['email'])->first();
   
    if ($subscription)
    {
      return $this->activateSubscriber->execute($subscription, TRUE);
    }

    return $this->createSubscriber->execute([
      'mailinglist' => Mailinglist::find($data['mailinglist']->id),
      'email' => $data['email']
    ], TRUE);
  }
}