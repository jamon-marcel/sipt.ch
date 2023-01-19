<?php
namespace App\Console\Commands;
use App\Models\User;
use App\Models\Student;
use Illuminate\Console\Command;

class UserUpdate extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'user:update';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Updates a users newsletter subscription';

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
    $id = $this->ask('User id: ');

    $user = User::find($id);

    if (!$user)
    {
      $this->warn('No user with this id!');
    }
    else
    {
      $user->is_newsletter_subscriber = 0;
      $user->save();
      $this->info('User Updated');
    }
    return self::SUCCESS;
  }
}
