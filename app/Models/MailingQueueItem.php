<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class MailingQueueItem extends Model
{
  protected $fillable = [
    'hash',
    'error',
    'processed',
    'mailing_queue_id',
    'mailinglist_subscriber_id'
  ];

  public function queue()
  {
    return $this->belongsTo(MailingQueue::class);
  }

  public function subscriber()
  {
    return $this->belongsTo(MailinglistSubscriber::class, 'mailinglist_subscriber_id', 'id');
  }

  public function scopeNotProcessed($query)
  {
    return $query->where('processed', 0);
  }
}
