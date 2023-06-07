<?php
namespace App\Console\Commands;
use App\Models\Mailinglist;
use App\Models\MailinglistSubscriber;
use Illuminate\Console\Command;

class MailingPreview extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'mailing:preview';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Send a mailing preview';

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
  public function handle(): int
  {
    // Get all mailinglists
    $mailinglists = Mailinglist::all();

    // Ask the user to select a mailinglist
    $mailinglist = $this->choice('Which mailinglist?', $mailinglists->pluck('description')->all());

    // find mailinglist by description
    $mailinglist = Mailinglist::where('description', $mailinglist)->first();

    // ask for email address
    $email = $this->ask('Email address?');

    // find subscriber by email address
    $subscriber = MailinglistSubscriber::where('email', $email)->where('mailinglist_id', $mailinglist->id)->first();

    if ($subscriber)
    {
      $subscriber->is_processed = 0;
      $subscriber->save();
    }
    else 
    {
      $this->info('no user found for this email address or mailinglist');
    }

    return self::SUCCESS;
  }
}
