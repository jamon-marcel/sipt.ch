<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class CourseEvent extends Model
{
	protected $fillable = [
		'course_id',
		'max_participants',
		'location_id',
		'is_online',
		'is_published',
		'is_cancelled',
	];
	
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
