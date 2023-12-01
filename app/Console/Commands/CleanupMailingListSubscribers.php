<?php
namespace App\Console\Commands;
use App\Models\Mailinglist;
use App\Models\MailinglistSubscriber;
use App\Models\User;
use Illuminate\Console\Command;

class CleanupMailingListSubscribers extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'cleanup:subscribers';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Compares mailinglist subscribers and deletes them if necessary';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {
    // Get all subscribers with an email like @yahoo
    $subscribers = MailinglistSubscriber::where('email', 'like', '%@yahoo%')->get();
    foreach($subscribers as $subscriber)
    {
      $user = User::where('email', $subscriber->email)->first();
      if (!$user)
      {
        $this->info('No user found with email: ' . $subscriber->email);
        $this->info('Deleting user...');
        $subscriber->delete();
      }
      else {
        $this->info('User found with email: ' . $subscriber->email);
      }
    }
  }
}
