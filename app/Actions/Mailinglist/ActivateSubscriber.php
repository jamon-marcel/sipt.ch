<?php
namespace App\Actions\Mailinglist;
use App\Models\MailinglistSubscriber;

class ActivateSubscriber
{
  public function execute(MailinglistSubscriber $mailinglistSubscriber, $confirmed = false)
  {
    $mailinglistSubscriber->deleted_at = NULL;
    // $mailinglistSubscriber->is_processed = 1;
    $mailinglistSubscriber->is_confirmed = $confirmed;
    $mailinglistSubscriber->save();
    return $mailinglistSubscriber;
  }
}