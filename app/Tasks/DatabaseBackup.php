<?php
namespace App\Tasks;

class DatabaseBackup
{
  public function __invoke()
  {
    // call the artisan command
    \Artisan::call('database:backup');
  }
}