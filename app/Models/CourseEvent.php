<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class CourseEvent extends Model
{
	protected $fillable = [
		'course_id',
		'max_participants',
		'dateStart',
		'location_id',
		'is_online',
		'is_bookable',
		'is_published',
		'is_cancelled',
	];
	
  /**
   * Mutator 'setDateStart'
   */

  public function setDateStartAttribute($value)
  {
    $this->attributes['dateStart'] = \Carbon\Carbon::parse($value)->format('Y.m.d');
	}
	
  /**
   * Accessor 'getDateStart'
   */

  public function getDateStartAttribute($value)
  {
    return \Carbon\Carbon::parse($value)->format('d.m.Y');
  }

	public function dates()
	{
		return $this->hasMany('App\Models\CourseEventDate')->orderBy('date');
	}

	public function location()
	{
		return $this->hasOne('App\Models\Location', 'id', 'location_id');
	}

  public function course()
  {
    return $this->belongsTo('App\Models\Course');
	}
	
	public function students()
	{
		return $this->belongsToMany('App\Models\Student');
	}
}
