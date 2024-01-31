<?php
namespace App\Tasks;
use App\Actions\Mailinglist\ProcessQueue;

class MailingQueue
{
  public function __invoke()
  {
    (new ProcessQueue())->execute();
  }
}