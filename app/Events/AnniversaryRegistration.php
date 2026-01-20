<?php
namespace App\Events;
use App\Models\AnniversaryRegistration as AnniversaryRegistrationModel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AnniversaryRegistration
{
  use Dispatchable, SerializesModels;

  public $registration;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct(AnniversaryRegistrationModel $registration)
  {
    $this->registration = $registration;
  }
}
