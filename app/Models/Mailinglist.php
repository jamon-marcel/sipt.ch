<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Mailinglist extends Model
{
  protected $fillable = [
    'short_description',
    'description',
    'order',
	];

  public function mailingQueue()
  {
    return $this->belongsToMany(MailingQueue::class, 'mailinglist_mailing_queue');
  }

  public function subscribers()
  {
    return $this->hasMany(MailinglistSubscriber::class);
  }
}
