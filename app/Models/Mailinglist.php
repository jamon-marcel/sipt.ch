<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Mailinglist extends Model
{
  protected $fillable = [
    'description',
    'order',
	];

  public function mailings()
  {
    return $this->belongsToMany(Mailing::class, 'mailing_mailinglist');
  }

  public function subscribers()
  {
    return $this->hasMany(MailinglistSubscriber::class);
  }
}
