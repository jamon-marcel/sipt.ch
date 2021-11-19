<?php
namespace App\Events;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TutorStored
{
  use Dispatchable, SerializesModels;

  public $user;
  public $user_data;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct(User $user, $user_data)
  {
    $this->user = $user;
    $this->user_data = $user_data;
  }
}
