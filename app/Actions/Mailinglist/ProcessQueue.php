<?php
namespace App\Actions\Mailinglist;
use App\Models\Mailing;
use App\Models\MailingList;
use App\Models\MailingQueue;
use App\Models\MailinglistSubscriber;

class ProcessQueue
{
  public function execute()
  {
    $mailingQueue = MailingQueue::notProcessed()->with('mailing.attachments', 'notProcessedItems.subscriber.mailinglist', 'processedItems', 'items')->first();

    // No unprocessed mailing queue found, so nothing to do
    if (!$mailingQueue) {
      echo "No unprocessed mailing queue found.\n";
      return null;
    }

    // If there is no mailing queue to process because all are processed, set the mailing queue as processed and return
    if(
      $mailingQueue->items && $mailingQueue->processedItems &&
      $mailingQueue->items->count() > 0 &&
      $mailingQueue->items->count() == $mailingQueue->processedItems->count()
    )
    {
      $mailingQueue->processed = 1;
      $mailingQueue->save();
      echo "Mailing queue #{$mailingQueue->id} marked as processed (all items already sent).\n";
      return null;
    }

    $itemsToProcess = $mailingQueue->notProcessedItems->take(2);
    $totalItems = $mailingQueue->notProcessedItems->count();

    echo "Processing mailing queue #{$mailingQueue->id}\n";
    echo "Mailing: {$mailingQueue->mailing->subject}\n";
    echo "Total unprocessed items: {$totalItems}\n";
    echo "Processing batch: " . $itemsToProcess->count() . " emails\n\n";

    $sent = 0;
    $failed = 0;

    foreach($itemsToProcess as $mq)
    {
      try {
        echo "Sending to: {$mq->subscriber->email}... ";
        \Mail::to($mq->subscriber->email)
        ->send(
          new \App\Mail\Mailing([
            'mailing' => $mailingQueue->mailing,
            'subscriber'  => $mq->subscriber,
          ])
        );
        $mq->processed = 1;
        $mq->save();
        echo "✓ Sent\n";
        $sent++;
      }
      catch(\Throwable $e) {
        $mq->error = $e->getMessage();
        $mq->processed = 1;
        $mq->save();
        echo "✗ Failed: {$e->getMessage()}\n";
        $failed++;
      }
    }

    echo "\n";
    echo "Summary:\n";
    echo "- Sent successfully: {$sent}\n";
    echo "- Failed: {$failed}\n";
    echo "- Remaining in queue: " . ($totalItems - $itemsToProcess->count()) . "\n";

    return [
      'sent' => $sent,
      'failed' => $failed,
      'remaining' => $totalItems - $itemsToProcess->count()
    ];
  }
}