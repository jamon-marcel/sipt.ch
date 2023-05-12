<?php
namespace App\Console\Commands;
use App\Models\Mailinglist;
use App\Models\MailinglistSubscriber;
use Illuminate\Console\Command;

class ActivateMailinglistSubscribers extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'activate:mailinglist';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Activates a mailinglist';

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
    // Get all mailinglists
    $mailinglists = Mailinglist::all();

    // Ask the user to select a mailinglist
    $mailinglist = $this->choice('Which mailinglist?', $mailinglists->pluck('description')->all());

    // find mailinglist by description
    $mailinglist = Mailinglist::where('description', $mailinglist)->first();

    if ($mailinglist)
    {
      if ($this->confirm('Do you wish to activate all users form the list "' . $mailinglist->description . '"?'))
      {
        MailinglistSubscriber::where('mailinglist_id', $mailinglist->id)->update(['is_processed' => 0]);
      }
    }
  }
}
