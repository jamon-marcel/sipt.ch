<?php
namespace App\Actions\Mailinglist;
use App\Models\MailinglistSubscriber;

class GetSubscriptions
{
  public function execute($email = NULL)
  {
    return MailinglistSubscriber::where('email', $email)->get();
  }
}