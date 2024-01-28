<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class MailingMailinglist extends Model
{
  protected $table = 'mailing_mailinglist';

  protected $fillable = [
    'batch_id',
    'mailing_id',
    'mailinglist_id',
  ];

  public function mailing()
  {
    return $this->belongsTo(Mailing::class);
  }

  public function mailinglist()
  {
    return $this->belongsTo(Mailinglist::class);
  }
}

