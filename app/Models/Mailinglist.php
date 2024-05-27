<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Mailinglist extends Model
{
  protected $fillable = [
    'short_description',
    'description',
    'order',
    'public'
	];

  public function mailingQueue()
  {
    return $this->belongsToMany(MailingQueue::class, 'mailinglist_mailing_queue');
  }

  public function subscribers()
  {
    return $this->hasMany(MailinglistSubscriber::class);
  }

  public function activeSubscribers()
  {
    return $this->hasMany(MailinglistSubscriber::class)->where('is_confirmed', 1)->whereNull('deleted_at');
  }

  public function scopePublic($query)
  {
    return $query->where('public', 1);
  }
}
