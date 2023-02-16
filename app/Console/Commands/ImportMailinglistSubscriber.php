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
    $advertisment_subscribers_data = json_decode(file_get_contents(storage_path() . "/app/public/advertisment_subscribers.json"), true);
    $important_notice_subscribers_data = json_decode(file_get_contents(storage_path() . "/app/public/important_notice_subscribers.json"), true);
    $newsletter_subscribers_data = json_decode(file_get_contents(storage_path() . "/app/public/newsletter_subscribers.json"), true);

    // 1. Add all previous subscribers to the list "Newsletter/Aufbautipp"
    $users = User::where('is_newsletter_subscriber', 1)->get();
    $list_id = env('MAILINGLIST_NEWSLETTER');
    foreach($users as $user)
    {
      MailinglistSubscriber::create([
        'description' => 'Newsletter/Aufbautipp',
        'mailinglist_id' => $list_id,
        'email' => $user->email,
        'is_processed' => 1,
        'is_confirmed' => 1,
      ]);
    }

    // Loop over json files and add, if not already added
    // foreach($advertisment_subscribers_data as $user)
    // {
    //   // Check if already added
    //   $already_added = MailinglistSubscriber::where('email', $user['email'])->first();
    //   if (!$already_added)
    //   {
    //     MailinglistSubscriber::create([
    //       'description' => 'Newsletter/Aufbautipp',
    //       'mailinglist_id' => env('MAILINGLIST_NEWSLETTER'),
    //       'email' => $user['email'],
    //       'is_processed' => 1,
    //       'is_confirmed' => 1,
    //     ]);
    //   }
    //   $this->info('added email: ' . $user['email'] . ' from advertisment_subscribers.json');
    // }

    foreach($important_notice_subscribers_data as $user)
    {
      // Check if already added
      $already_added = MailinglistSubscriber::where('email', $user['email'])->first();
      if (!$already_added)
      {
        MailinglistSubscriber::create([
          'description' => 'Newsletter/Aufbautipp',
          'mailinglist_id' => env('MAILINGLIST_NEWSLETTER'),
          'email' => $user['email'],
          'is_processed' => 1,
          'is_confirmed' => 1,
        ]);
      }
      $this->info('added email: ' . $user['email'] . ' from advertisment_subscribers.json');
    }
    foreach($newsletter_subscribers_data as $user)
    {
      // Check if already added
      $already_added = MailinglistSubscriber::where('email', $user['email'])->first();
      if (!$already_added)
      {
        MailinglistSubscriber::create([
          'description' => 'Newsletter/Aufbautipp',
          'mailinglist_id' => env('MAILINGLIST_NEWSLETTER'),
          'email' => $user['email'],
          'is_processed' => 1,
          'is_confirmed' => 1,
        ]);
      }
      $this->info('added email: ' . $user['email'] . ' from advertisment_subscribers.json');
    }
  }
}
