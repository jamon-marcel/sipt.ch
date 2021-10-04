<?php
namespace App\Console;
use App\Tasks\CourseEventBills;
use App\Tasks\CourseEventInvitations;
use App\Tasks\CourseEventReminder;
use App\Tasks\SymposiumBills;
use App\Tasks\Message;
use App\Tasks\Newsletter;
use App\Tasks\Advertisment;
use App\Tasks\SymposiumNews;
use App\Tasks\ImportantNotice;
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
    // $schedule->call(new CourseEventBills)->everyMinute();
    // $schedule->call(new CourseEventInvitations)->everyMinute();
    // $schedule->call(new CourseEventReminder)->everyMinute();
    // $schedule->call(new Message)->everyMinute();
    // $schedule->call(new SymposiumNews)->everyMinute();
    // $schedule->call(new SymposiumBills)->everyMinute();
    // $schedule->call(new Newsletter)->everyMinute();
    // $schedule->call(new Advertisment)->everyMinute();
    // $schedule->call(new ImportantNotice)->everyMinute();
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