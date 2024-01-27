<?php
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class MailingAttachment extends Model
{
  protected $fillable = [
    'name',
    'mailing_id',
  ];

  public function mailing()
  {
    return $this->belongsTo(Mailing::class);
  }
}
