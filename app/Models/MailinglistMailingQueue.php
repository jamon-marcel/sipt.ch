<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class MailinglistMailingQueue extends Model
{
  protected $table = 'mailinglist_mailing_queue';

  protected $fillable = [
    'mailing_queue_id',
    'mailinglist_id',
  ];

  public function mailingQueue()
  {
    return $this->belongsTo(MailingQueue::class);
  }

  public function mailinglist()
  {
    return $this->belongsTo(Mailinglist::class);
  }
}

