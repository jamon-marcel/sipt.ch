<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class MessageLog extends Model
{
  protected $table = 'message_log';
  
	protected $fillable = [
    'email',
    'student_id',
    'is_sent',
    'message_id',
  ];

  public function message()
	{
		return $this->hasOne('App\Models\Message', 'id', 'message_id');
  }
  
	public function sendables()
	{
		return $this->with('message')->where('is_sent', '=', 0);
	}
}
