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
    $mailingQueue = MailingQueue::with('mailinglist')->notProcessed()->limit(3)->get();

    foreach($mailingQueue->all() as $mq)
    {
      $mailing = Mailing::with('attachments')->findOrFail($mq->mailing_id);
      try {
        \Mail::to($mq->email)
        ->send(
          new \App\Mail\Mailing([
            'mailing' => $mailing,
            'subscriber'  => $mq,
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