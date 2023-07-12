<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;

class DatabaseBackup extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'database:backup';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Backs up the entire database and stores it in the storage/app/backups folder';

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
    // get the current time
    $now = now();

    // get the database name
    $database = env('DB_DATABASE');

    // get the database username
    $username = env('DB_USERNAME');

    // get the database password
    $password = env('DB_PASSWORD');

    // get the database host
    $host = env('DB_HOST');

    // get the backup folder path
    $backup_folder = storage_path('app/backups');

    // create folder if it doesn't exist
    if (!file_exists($backup_folder))
    {
      mkdir($backup_folder, 0777, true);
    }

    // create the file name
    $file_name = $backup_folder . '/' . $now->format('Y-m-d-H-i-s') . '.sql';

    // create the command
    $command = sprintf('mysqldump -u%s -p%s -h%s %s > %s', $username, $password, $host, $database, $file_name);

    // execute the command
    exec($command);

    // return success
    return self::SUCCESS;

  }
}
