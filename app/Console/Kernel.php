<?php
namespace App\Console;
use App\Tasks\CourseEventBills;
use App\Tasks\CourseEventInvitations;
use App\Tasks\CourseEventReminder;
use App\Tasks\Message;
use App\Tasks\DatabaseBackup;
use App\Tasks\Mailing;
use App\Tasks\MailingQueue;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
  /**
   * The Artisan commands provided by your application.
   *
   * @var array
   */
  protected $commands = [
    //
  ];

  /**
   * Define the application's command schedule.
   *
   * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
   * @return void
   */
  protected function schedule(Schedule $schedule)
  {
    // $schedule->call(new MailingQueue)->everyMinute();

    if (\App::environment('production'))
    {
      $schedule->call(new CourseEventBills)->everyMinute();
      $schedule->call(new CourseEventInvitations)->everyMinute();
      $schedule->call(new CourseEventReminder)->everyMinute();
      $schedule->call(new Message)->everyMinute();
      $schedule->call(new Mailing)->everyMinute();
      $schedule->call(new DatabaseBackup)->daily();
    }
  }

  /**
   * Register the commands for the application.
   *
   * @return void
   */
  protected function commands()
  {
    $this->load(__DIR__.'/Commands');
    require base_path('routes/console.php');
  }
}