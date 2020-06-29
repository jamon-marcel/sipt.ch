<?php
namespace App\Events;
use App\Models\SymposiumSubscriber;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SymposiumConfirmSubscription
{
  use Dispatchable, SerializesModels;

  public $symposiumSubscriber;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct(SymposiumSubscriber $symposiumSubscriber)
  {
    $this->symposiumSubscriber = $symposiumSubscriber;
  }
}
