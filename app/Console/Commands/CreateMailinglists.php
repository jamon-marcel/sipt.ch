<?php
namespace App\Console\Commands;
use App\Models\Mailinglist;
use Illuminate\Console\Command;

class CreateMailinglists extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'create:mailinglists';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Creates mailinglists';

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
    $lists = [
      'Newsletter/Aufbautipp',
      'Fachbereich Berater',
      'Fachbereich Pädagogen',
      'Fachbereich Psychotherapeuten',
    ];

    foreach($lists as $key => $list)
    {
      Mailinglist::create([
        'uuid' => \Str::uuid(),
        'description' => $list,
        'order' => $key
      ]);
    }
  }
}
