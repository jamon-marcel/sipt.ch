<?php
namespace App\Console\Commands;
use App\Models\User;
use App\Models\SymposiumSubscriber;
use App\Models\ImportantNoticeSubscriber;
use App\Models\AdvertismentSubscriber;
use App\Models\NewsletterSubscriber;
use App\Models\MessageLog;
use Illuminate\Console\Command;

class AnonymizeEmail extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'anonymize:email';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Anonymizes all email addresses (doesnt work in production)!';

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
    if (!\App::environment('production'))
    {
      $users = [
        User::withTrashed()->get(),
        SymposiumSubscriber::withTrashed()->get(),
        ImportantNoticeSubscriber::withTrashed()->get(),
        AdvertismentSubscriber::withTrashed()->get(),
        NewsletterSubscriber::withTrashed()->get(),
        MessageLog::get()
      ];
  
      foreach($users as $user)
      {
        foreach($user as $u)
        {
          if ($u->email != 'm@marceli.to')
          {
            $u->email = \Str::random(24) . '@test.sipt.ch';
            $u->save();
          }
        }
      }
    }
  }
}
