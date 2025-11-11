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
    $this->info('Starting mailing queue processing...');

    $action = new ProcessQueue();
    $result = $action->execute();

    if ($result === null) {
      $this->warn('No unprocessed mailing queues found or all items already processed.');
      return self::SUCCESS;
    }

    $this->info('Mailing queue processed successfully!');
    return self::SUCCESS;
  }
}
