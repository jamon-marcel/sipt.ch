<?php
namespace App\Events;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CourseEventBill
{
  use Dispatchable, SerializesModels;

  public $notifyUser;
  
  /**
   * Create a new event instance.
   * 
   * @param Boolean $notifyUser
   * @return void
   */
  public function __construct($notifyUser)
  {
    $this->notifyUser = $notifyUser;
  }
}
