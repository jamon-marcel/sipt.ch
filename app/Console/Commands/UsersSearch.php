<?php
namespace App\Console\Commands;
use App\Models\User;
use App\Models\Student;
use App\Models\Tutor;
use Illuminate\Console\Command;

class UsersSearch extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'users:search';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Search for users in the system';

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
    $searchTerm = $this->ask('Search term: ');

    $students = Student::with('user')->search($searchTerm);
    $tutors   = Tutor::with('user')->search($searchTerm);

    $rows = [];
    $rows[] = $students->map(fn (Student $student): array => [
      $student->firstname,
      $student->name,
      $student->street,
      $student->city,
      $student->user->email,
      $student->user->id,
      $student->user->is_newsletter_subscriber,
      $student->user->role,
    ])->all();

    $rows[] = $tutors->map(fn (Tutor $tutor): array => [
      $tutor->firstname,
      $tutor->name,
      $tutor->street,
      $tutor->city,
      $tutor->user->email,
      $tutor->user->id,
      $tutor->user->is_newsletter_subscriber,
      $tutor->user->role,
    ])->all();

    $this->info('Found '.count($rows).' entries');
    $this->table(['Firstname', 'Name', 'Street', 'City', 'Email', 'UserId', 'Subscribed', 'Type'], $rows);

    return self::SUCCESS;
  }
}
