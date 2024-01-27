<?php
namespace App\Tasks;
use App\Actions\Mailinglist\ProcessQueue;

class Mailing
{
  public function __invoke()
  {
    (new ProcessQueue())->execute();
  }
}