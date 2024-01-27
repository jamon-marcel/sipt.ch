<?php
namespace App\Console\Commands;
use App\Actions\Mailinglist\ProcessQueue;
use Illuminate\Console\Command;

class MailingProcess extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'mailing:process';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Process mailing queue items';

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
    (new ProcessQueue())->execute();
    return self::SUCCESS;
  }
}
