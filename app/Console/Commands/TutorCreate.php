<?php
namespace App\Console\Commands;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TutorCreate extends Command
{
  protected $signature = 'tutor:create';

  protected $description = 'Creates a new tutor (and the associated user account, marked as verified)';

  public function __construct()
  {
    parent::__construct();
  }

  public function handle(): int
  {
    $firstname = $this->ask('Firstname');
    $name      = $this->ask('Name');
    $email     = $this->ask('Email');
    $password  = $this->secret('Password');

    $validator = Validator::make(
      compact('firstname', 'name', 'email', 'password'),
      [
        'firstname' => 'required|string|max:100',
        'name'      => 'required|string|max:100',
        'email'     => 'required|email|unique:users,email',
        'password'  => 'required|string|min:6',
      ]
    );

    if ($validator->fails())
    {
      foreach ($validator->errors()->all() as $error)
      {
        $this->error($error);
      }
      return self::FAILURE;
    }

    try
    {
      $tutor = DB::transaction(function () use ($firstname, $name, $email, $password) {
        $user = User::create([
          'email'             => $email,
          'email_verified_at' => \Carbon\Carbon::now(),
          'password'          => Hash::make($password),
          'role'              => 'tutor',
        ]);

        return Tutor::create([
          'firstname' => $firstname,
          'name'      => $name,
          'user_id'   => $user->id,
        ]);
      });
    }
    catch (\Exception $e)
    {
      $this->error('Failed to create tutor: ' . $e->getMessage());
      return self::FAILURE;
    }

    $this->info("Tutor created (id: {$tutor->id})");
    return self::SUCCESS;
  }
}
