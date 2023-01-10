<?php
namespace App\Console\Commands;
use App\Models\Mailinglist;
use App\Models\MailinglistSubscriber;
use App\Models\User;
use Illuminate\Console\Command;

class ImportMailinglistSubscriber extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'import:mailinglistsubscriber';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Imports mailinglist subscribers';

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
    $users = User::where('is_newsletter_subscriber', 1)->get();

    // 1. Add all previous subscribers to the list "Newsletter/Aufbautipp"
    $list_id = env('MAILINGLIST_NEWSLETTER');

    // // 2. Randomly add other lists
    // $list_ids = [
    //   [
    //     'id' => '0a53dcf2-d933-4cc5-bca7-69ab304d5543',
    //     'description' => 'Fachbereich Berater',
    //   ],
    //   [
    //     'id' => '43d4d3f8-546d-49fd-9515-84c67a8b5b92',
    //     'description' => 'Fachbereich Pädagogen',
    //   ],
    //   [
    //     'id' => '96313713-32b7-4f7e-8e20-64b34e0f8fb0',
    //     'description' => 'Fachbereich Psychotherapeuten',
    //   ],
    // ];

    foreach($users as $user)
    {
      MailinglistSubscriber::create([
        'description' => 'Newsletter/Aufbautipp',
        'mailinglist_id' => $list_id,
        'email' => $user->email,
        'is_processed' => 1,
        'is_confirmed' => 1,
      ]);

      // $rand = mt_rand(0,2);
      // MailinglistSubscriber::create([
      //   'description' => $list_ids[$rand]['description'],
      //   'mailinglist_id' => $list_ids[$rand]['id'],
      //   'email' => $user->email,
      //   'is_processed' => 1,
      //   'is_confirmed' => 1,
      // ]);
    }
  }
}
