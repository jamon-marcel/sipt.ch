<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Mailing;
use App\Models\MailingQueue;
use App\Models\MailingQueueItem;
use App\Models\MailingList;
use App\Models\MailinglistSubscriber;
use App\Models\MailinglistMailingQueue;

use App\Events\MailingQueueItemRemoved;
use Illuminate\Http\Request;

class MailingQueueController extends Controller
{
  public function get(Mailing $mailing)
  {
    $batches = MailingQueue::with('items.subscriber', 'mailinglist')->where('mailing_id', $mailing->id)->orderBy('created_at', 'DESC')->get();
    return response()->json(['batches' => $batches, 'mailing' => $mailing]);
  }

  public function destroyEntry(MailingQueueItem $mailingQueueItem)
  {
    $mailingQueueItem->delete();
    event(new MailingQueueItemRemoved($mailingQueue->mailing, $mailingQueue->mailinglist));

    return response()->json([
      'message' => 'Queue entry deleted'
    ]);
  }

  public function destroyBatch(MailingQueue $mailingQueue)
  {
    $mailingQueue->mailinglist()->detach();
    $mailingQueue->items()->delete();
    $mailingQueue->delete();
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

    // Create mailing queue entry
    $mailing_id = request()->input('mailing_id');
    $mailingQueue = MailingQueue::create([
      'processed' => 0,
      'mailing_id' => $mailing_id,
    ]);

    $list_ids = request()->input('list_ids');

    // Loop through the list_ids and queue them
    foreach($list_ids as $list_id)
    {
      // Add the mailinglist
      MailinglistMailingQueue::create([
        'mailinglist_id' => $list_id,
        'mailing_queue_id' => $mailingQueue->id,
      ]);

      // Get subscribers from the list
      $subscribers = MailinglistSubscriber::active()->where('mailinglist_id', $list_id)->get();

      // Loop through the subscribers and queue them
      foreach($subscribers->all() as $s)
      {
        MailingQueueItem::firstOrCreate(
          [
            'hash' => $s->hash,
            'mailing_queue_id' => $mailingQueue->id,
          ],
          [
            'hash' => $s->hash,
            'processed' => 0,
            'mailinglist_subscriber_id' => $s->id,
            'mailing_queue_id' => $mailingQueue->id,
          ]
        );
      }
    }

    return response()->json([
      'message' => 'Mailing queued'
    ]);
  }
}