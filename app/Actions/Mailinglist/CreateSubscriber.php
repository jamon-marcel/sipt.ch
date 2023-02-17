<?php
namespace App\Actions\Mailinglist;
use App\Models\MailinglistSubscriber;

class CreateSubscriber
{
  public function execute($data, $confirmed = FALSE)
  {
    return MailinglistSubscriber::create([
      'id' => \Str::uuid(),
      'email' => $data['email'],
      'hash' => md5($data['email']),
      'mailinglist_id' => $data['mailinglist']->id,
      'description' => $data['mailinglist']->description,
      'is_processed' => 1,
      'is_confirmed' => $confirmed ? 1 : 0
    ]);
  }
}