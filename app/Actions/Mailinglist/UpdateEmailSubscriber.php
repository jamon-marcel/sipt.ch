<?php
namespace App\Actions\Mailinglist;
use App\Models\MailinglistSubscriber;

class UpdateEmailSubscriber
{
  public function execute($oldEmail, $newEmail)
  {
    return MailinglistSubscriber::where('email', $oldEmail)->update(['email' => $newEmail]);
  }
}