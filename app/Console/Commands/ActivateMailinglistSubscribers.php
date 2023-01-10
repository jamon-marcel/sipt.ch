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
  protected $signature = 'activate:mailinglist {listUuid}';

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
    $listUuid = $this->argument('listUuid');

    $list = Mailinglist::find($listUuid);
    if ($list)
    {
      if ($this->confirm('Do you wish to activate all users form the list "' . $list->description . '"?'))
      {
        MailinglistSubscriber::where('mailinglist_id', $list->id)->update(['is_processed' => 0]);
      }
    }
  }
}
