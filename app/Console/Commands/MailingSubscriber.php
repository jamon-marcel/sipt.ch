<?php
namespace App\Console\Commands;
use App\Models\Mailinglist;
use App\Models\MailinglistSubscriber;
use Illuminate\Console\Command;

class MailingSubscriber extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'mailing:subscriber';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Add a subscriber to a mailinglist';

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
    // ask for list
    $mailinglist = Mailinglist::orderBy('order')->get();
    $mailinglist_id = $this->choice('Which mailinglist?', $mailinglist->pluck('description')->toArray());

    // ask for email
    $email = $this->ask('What is the email address?');

    // add to list
    $subscriber = MailinglistSubscriber::firstOrCreate([
      'email' => $email,
      'hash' => md5($email),
      'is_confirmed' => 1,
      'mailinglist_id' => $mailinglist->where('description', $mailinglist_id)->first()->id
    ]);

    return self::SUCCESS;
  }
}
