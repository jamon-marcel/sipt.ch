<?php
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Message extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
    'course_event_id',
    'date',
    'subject',
    'message',
    'senderName',
    'senderEmail'
  ];
  

	/**
	 * Relationship for all events
	 */

	public function event()
	{
		return $this->hasOne('App\Models\CourseEvent', 'id', 'course_event_id');
  }
  
  /**
   * Mutator 'setDate'
   */

  public function setDateAttribute($value)
  {
    $this->attributes['date'] = \Carbon\Carbon::parse($value)->format('Y.m.d');
  }
  
  /**
   * Accessor 'getDate'
   */

  public function getDateAttribute($value)
  {
    return \Carbon\Carbon::parse($value)->format('d.m.Y');
  }

  /**
   * Accessor 'getMessage'
   */

  public function getMessageAttribute($value)
  {
    return nl2br($value);
  }
}
