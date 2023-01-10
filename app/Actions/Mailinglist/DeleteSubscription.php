<?php
namespace App\Actions\Mailinglist;
use App\Models\MailinglistSubscriber;

class DeleteSubscription
{
  public function execute(MailinglistSubscriber $mailinglistSubscriber)
  {
    return $mailinglistSubscriber->delete();
  }
}