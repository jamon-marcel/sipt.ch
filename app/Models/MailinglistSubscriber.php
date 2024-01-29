<?php
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class MailinglistSubscriber extends Model
{
  use SoftDeletes;

  protected $table = 'mailinglist_subscriber';

	protected $fillable = [
    'id',
    'mailinglist_id',
    'email',
    'hash',
    'is_confirmed'
	];

  public function mailinglist()
  {
    return $this->belongsTo(Mailinglist::class);
  }

  public function scopeConfirmed($query)
  {
    return $query->where('is_confirmed', '=', '1');
  }

	public function scopeActive($query)
	{
    return $query->where('is_confirmed', '=', '1')->whereNull('deleted_at');
	}  

}
