<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class MailingQueue extends Model
{
  protected $table = 'mailing_queue';

  protected $fillable = [
    'email',
    'hash',
    'error',
    'processed',
    'mailing_id',
    'mailinglist_id',
    'mailinglist_subscriber_id'
  ];

  public function mailing()
  {
    return $this->belongsTo(Mailing::class);
  }

  public function mailinglist()
  {
    return $this->belongsTo(Mailinglist::class);
  }

  public function mailinglistSubscriber()
  {
    return $this->belongsTo(MailinglistSubscriber::class);
  }

  public function scopeNotProcessed($query)
  {
    return $query->where('processed', 0);
  }
}
