<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Mailing;
use App\Models\MailingQueue;
use App\Models\MailingList;
use App\Models\MailinglistSubscriber;
use App\Models\MailingMailinglist;
use Illuminate\Http\Request;

class MailingQueueController extends Controller
{
  public function get(Mailing $mailing)
  {
    $queue = $mailing->queue()->with('mailinglist')->orderBy('processed', 'DESC')->get();

    // group by mailinglist_id, create an array as follows:
    // ['mailinglist' => [id, description, items => [queue items]]
    $queue_grouped = [];
    foreach($queue->all() as $q)
    {
      // add the mailinglist to the array if it doesn't exist
      if (!isset($queue_grouped[$q->mailinglist_id]))
      {
        $queue_grouped[$q->mailinglist_id]['id'] = $q->mailinglist_id;
        $queue_grouped[$q->mailinglist_id]['description'] = $q->mailinglist->description;
      }

      // add the queue item to the mailinglist
      $queue_grouped[$q->mailinglist_id]['items'][] = $q;
    }

    return response()->json(['mailing' => $mailing, 'list_items' => $queue_grouped]);
  }

  public function destroyEntry(MailingQueue $mailingQueue)
  {
    $mailingQueue->delete();
    return response()->json([
      'message' => 'Queue entry deleted'
    ]);
  }

  public function destroyList($mailingId, $mailingListId)
  {
    $mailing = Mailing::findOrFail($mailingId);
    $mailingList = MailingList::findOrFail($mailingListId);

    // remove all queue items for this mailinglist
    MailingQueue::where('mailinglist_id', $mailingList->id)
      ->where('mailing_id', $mailing->id)
      ->where('processed', 0)
      ->delete();

    // get all mailinglists for this mailing
    $mailingLists = $mailing->mailinglists()->get();

    // detach the mailing from the mailinglist if there are no more queue items for this mailinglist
    foreach($mailingLists->all() as $ml)
    {
      $mailingQueue = MailingQueue::where('mailinglist_id', $ml->id)
        ->where('mailing_id', $mailing->id)
        ->first();

      if (!$mailingQueue)
      {
        $ml->mailings()->detach($mailing->id);
      }
    }

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
            'mailing_id' => $mailing_id,
          ],
          [
            'id' => \Str::uuid(),
            'hash' => $s->hash,
            'mailinglist_id' => $list_id,
            'mailinglist_subscriber_id' => $s->id
          ]
        );
      }

      $mailingMailinglist = MailingMailinglist::firstOrCreate(
        [
          'mailing_id' => $mailing_id,
          'mailinglist_id' => $list_id
        ],
        [
          'id' => \Str::uuid(),
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