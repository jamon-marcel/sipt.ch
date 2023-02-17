<?php
namespace App\Console\Commands;
use App\Models\Mailinglist;
use App\Models\MailinglistSubscriber;
use App\Models\User;
use Illuminate\Console\Command;

class UpdateMailinglistSubscriber extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'update:mailinglistsubscriber';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Updates mailinglist subscribers';

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
    $subscribers = MailinglistSubscriber::withTrashed()->get();
    foreach($subscribers as $subscriber)
    {
      $subscriber->hash = md5($subscriber->email);
      $subscriber->save();
    }
  }
}
