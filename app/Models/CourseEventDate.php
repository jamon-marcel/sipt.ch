<?php
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class CourseEventDate extends Model
{
  use SoftDeletes;

	protected $fillable = [
		'date',
		'timeStart',
    'timeEnd',
    'tutor_id',
		'course_event_id',
  ];

  protected $appends = [
    'timeStart',
    'timeEnd',
  ];

	public function tutor()
	{
		return $this->hasOne('App\Models\Tutor', 'id', 'tutor_id');
	}

	public function courseEvent()
	{
		return $this->belongsTo('App\Models\CourseEvent');
	}

  /**
   * Mutator 'setDate'
   */

  public function setDateAttribute($value)
  {
    $this->attributes['date'] = \Carbon\Carbon::parse($value)->format('Y.m.d');
  }

  /**
   * Mutator 'setTimeStart'
   */

  public function setTimeStartAttribute($value)
  {
    $this->attributes['timeStart'] = \Carbon\Carbon::parse($value)->format('H:i:s');
  }

  /**
   * Mutator 'setTimeEnd'
   */

  public function setTimeEndAttribute($value)
  {
    $this->attributes['timeEnd'] = \Carbon\Carbon::parse($value)->format('H:i:s');
  }

  /**
   * Accessor 'getDate'
   */

  public function getDateAttribute($value)
  {
    return \Carbon\Carbon::parse($value)->format('d.m.Y');
  }

  /**
   * Accessor 'getTimeStart'
   */

  public function getTimeStartAttribute($value)
  {
    return \Carbon\Carbon::parse($this->attributes['timeStart'])->format('H.i');
  }

  /**
   * Accessor 'getTimeEnd'
   */

  public function getTimeEndAttribute($value)
  {
    return \Carbon\Carbon::parse($this->attributes['timeEnd'])->format('H.i');
  }
}
