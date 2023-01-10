<?php
namespace App\Actions\Mailinglist;
use App\Models\MailinglistSubscriber;

class ConfirmSubscriber
{
  public function execute(MailinglistSubscriber $mailinglistSubscriber)
  {
    return MailinglistSubscriber::where('email', $mailinglistSubscriber->email)->update(['is_confirmed' => 1]);
  }
}