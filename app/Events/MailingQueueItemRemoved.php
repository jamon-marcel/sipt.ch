<?php
namespace App\Events;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MailingQueueItemRemoved
{
  use Dispatchable, SerializesModels;

  public $batchId;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($batchId)
  {
    $this->batchId = $batchId;
  }
}
