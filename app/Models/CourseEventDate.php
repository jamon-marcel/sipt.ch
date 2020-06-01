<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class CourseEventDate extends Model
{
	protected $fillable = [
		'date',
		'timeStart',
		'timeEnd',
		'course_event_id',
  ];

  /**
   * Mutator 'date'
   */

  public function setDateAttribute($value)
  {
    $this->attributes['date'] = \Carbon\Carbon::parse($value)->format('Y.m.d');
  }

  /**
   * Mutator 'timeStart'
   */

  public function setTimeStartAttribute($value)
  {
    $this->attributes['timeStart'] = \Carbon\Carbon::parse($value)->format('H:i:s');
  }

  /**
   * Mutator 'timeEnd'
   */

  public function setTimeEndAttribute($value)
  {
    $this->attributes['timeEnd'] = \Carbon\Carbon::parse($value)->format('H:i:s');
  }
}
