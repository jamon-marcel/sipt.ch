<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class MailingQueue extends Model
{
  protected $table = 'mailing_queue';

  protected $fillable = [
    'processed',
    'mailing_id',
  ];

  protected $casts = [
    'created_at' => 'datetime:d.m.Y H:i:s',
  ];

  public function items()
  {
    return $this->hasMany(MailingQueueItem::class);
  }

  public function notProcessedItems()
  {
    return $this->hasMany(MailingQueueItem::class)->where('processed', 0);
  }

  public function processedItems()
  {
    return $this->hasMany(MailingQueueItem::class)->where('processed', 1);
  }

  public function mailing()
  {
    return $this->belongsTo(Mailing::class);
  }

  public function mailinglist()
  {
    return $this->belongsToMany(Mailinglist::class, 'mailinglist_mailing_queue');
  }

  public function scopeNotProcessed($query)
  {
    return $query->where('processed', 0);
  }
}
