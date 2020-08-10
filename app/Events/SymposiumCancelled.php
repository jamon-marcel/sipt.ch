<?php
namespace App\Events;
use App\Models\Symposium;
use App\Models\SymposiumSubscriber;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SymposiumCancelled
{
  use Dispatchable, SerializesModels;

  public $symposium;
  public $symposiumSubscriber;
  public $penalty;
  
  /**
   * Create a new event instance.
   * @param SymposiumSubscriber $symposiumSubscriber
   * @param Symposium $symposium
   * @param Integer $penalty
   * @return void
   */
  public function __construct(SymposiumSubscriber $symposiumSubscriber, Symposium $symposium, $penalty)
  {
    $this->symposiumSubscriber = $symposiumSubscriber;
    $this->symposium = $symposium;
    $this->penalty = $penalty;
  }
}
