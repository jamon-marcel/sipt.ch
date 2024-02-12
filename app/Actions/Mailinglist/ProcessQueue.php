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

    // If there is no mailing queue to process because all are processed, set the mailing queue as processed and return
    if($mailingQueue->items->count() > 0 && ($mailingQueue->items->count() == $mailingQueue->processedItems->count()))
    {
      $mailingQueue->processed = 1;
      $mailingQueue->save();
      return;
    }

    $mailingQueue->notProcessedItems = $mailingQueue->notProcessedItems->take(2);
    foreach($mailingQueue->notProcessedItems as $mq)
    {
      try {
        \Mail::to($mq->subscriber->email)
        ->send(
          new \App\Mail\Mailing([
            'mailing' => $mailingQueue->mailing,
            'subscriber'  => $mq->subscriber,
          ])
        );
        $mq->processed = 1;
        $mq->save();
      }
      catch(\Throwable $e) {
        $mq->error = $e;
        $mq->processed = 1;
        $mq->save();
      }
    }
  }
}