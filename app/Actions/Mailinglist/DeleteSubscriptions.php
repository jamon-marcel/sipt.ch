<?php
namespace App\Actions\Mailinglist;
use App\Models\MailinglistSubscriber;
use App\Actions\Mailinglist\DeleteSubscription;

class DeleteSubscriptions
{
  public function __construct(DeleteSubscription $deleteSubscription)
  {
    $this->deleteSubscription = $deleteSubscription;
  }

  public function execute($email)
  {
    $mailinglistSubscribers = MailinglistSubscriber::where('email', $email)->get();
    foreach($mailinglistSubscribers as $mailinglistSubscriber)
    {
      $this->deleteSubscription->execute($mailinglistSubscriber);
    }
    return TRUE;
  }
}