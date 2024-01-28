<?php
namespace App\Listeners;
use App\Events\MailingQueueItemRemoved;
use App\Models\MailingMailinglist;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MailingListObserve
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  /**
   * Handle the event.
   *
   * @param  MailingQueueItemRemoved  $event
   * @return void
   */
  public function handle(MailingQueueItemRemoved $event)
  {
    return MailingMailinglist::where('batch_id', $event->batchId)->delete();
  }
}
