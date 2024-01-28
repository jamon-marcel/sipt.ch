<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Mailing;
use App\Models\MailingQueue;
use App\Models\MailingList;
use App\Models\MailinglistSubscriber;
use App\Models\MailingMailinglist;
use App\Events\MailingQueueItemRemoved;
use Illuminate\Http\Request;

class MailingQueueController extends Controller
{
  public function get(Mailing $mailing)
  {
    // get queue items from the mailing, include pivot data from mailing_mailinglist
    $queue = $mailing->queue()->with('mailinglist')->get();

    // sort by batch_id
    $queue = $queue->sortByDesc('batch_id');

    // Group by batch_id
    $queue_grouped = [];
    foreach($queue->all() as $q)
    {
      // add the batch_id to the array if it doesn't exist
      if (!isset($queue_grouped[$q->batch_id]))
      {
        // create date_time from batch_id
        $queue_grouped[$q->batch_id]['date_time'] = date('d.m.Y – H:i:s', $q->batch_id);
        $queue_grouped[$q->batch_id]['batch_id'] = $q->batch_id;
        $queue_grouped[$q->batch_id]['items'] = [];

        // get mailinglist data from mailing_mailinglist by batch_id
        $mailing_mailinglist = MailingMailinglist::with('mailinglist')->where('batch_id', $q->batch_id)->get();

        // get mailinglist description from each $mailing_mailinglist item, create comma separated string.
        // Use pluck to get an array of mailinglist descriptions, then implode to create a comma separated string.
        $mailing_mailinglist_descriptions = $mailing_mailinglist->pluck('mailinglist.description')->all();
        $queue_grouped[$q->batch_id]['mailinglists'] = $mailing_mailinglist_descriptions;
      }

      // add the queue item to the batch
      $queue_grouped[$q->batch_id]['items'][] = $q;

    }

    // remove the batch_id from the array and sort by date_time
    $queue_grouped = array_values($queue_grouped);
    $queue_grouped = collect($queue_grouped)->sortByDesc('date_time')->values()->all();

    return response()->json(['mailing' => $mailing, 'queue' => $queue_grouped]);
  }

  public function destroyEntry(MailingQueue $mailingQueue)
  {
    $mailingQueue->delete();
    event(new MailingQueueItemRemoved($mailingQueue->mailing, $mailingQueue->mailinglist));

    return response()->json([
      'message' => 'Queue entry deleted'
    ]);
  }

  public function destroyBatch($batchId)
  {
    MailingQueue::notProcessed()->where('batch_id', $batchId)->delete();
    event(new MailingQueueItemRemoved($batchId));

    return response()->json([
      'message' => 'Queue list deleted'
    ]);
  }

  public function preview()
  {
    $mailing = Mailing::findOrFail(request()->input('mailing_id'));
    \Mail::to(request()->input('email'))
    ->send(
      new \App\Mail\Mailing([
        'mailing' => $mailing,
      ])
    );  

    return response()->json([
      'message' => 'Preview sent'
    ]);
  }

  public function store()
  {
    // Validate the request
    request()->validate([
      'list_ids' => 'required',
      'mailing_id' => 'required'
    ]);

    $list_ids = request()->input('list_ids');
    $mailing_id = request()->input('mailing_id');
    $batch_id = time();

    // Loop through the list_ids and queue them
    foreach($list_ids as $list_id)
    {
      // Get subscribers from the list
      $subscribers = MailinglistSubscriber::active()->where('mailinglist_id', $list_id)->get();

      // Loop through the subscribers and queue them
      foreach($subscribers->all() as $s)
      {
        $mailingQueue = MailingQueue::firstOrCreate(
          [
            'email' => $s->email,
            'batch_id' => $batch_id,
          ],
          [
            'hash' => $s->hash,
            'mailing_id' => $mailing_id,
            'mailinglist_id' => $list_id,
            'mailinglist_subscriber_id' => $s->id
          ]
        );
      }

      $mailingMailinglist = MailingMailinglist::create(
        [
          'batch_id' => $batch_id,
          'mailing_id' => $mailing_id,
          'mailinglist_id' => $list_id
        ]
      );
    }

    return response()->json([
      'message' => 'Mailing queued'
    ]);
  }
}