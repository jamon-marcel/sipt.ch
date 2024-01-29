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
    $mailingQueue = MailingQueue::notProcessed()->with('mailing.attachments', 'notProcessedItems.subscriber.mailinglist')->first();

    // abort if there are no notProcessedItems
    if(!$mailingQueue || $mailingQueue->notProcessedItems->count() == 0)
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