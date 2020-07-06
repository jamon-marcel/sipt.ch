<?php
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class CourseEvent extends Model
{
	use SoftDeletes;
	
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

	public function dates()
	{
		return $this->hasMany('App\Models\CourseEventDate')->orderBy('date');
	}

	public function documents()
	{
		return $this->hasMany('App\Models\CourseEventFile');
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

  /**
   * Scope for upcoming events
   */

	public function scopeUpcoming($query)
	{
		$constraint = date('Y-m-d', time());
		return $query->where('dateStart', '>=', $constraint)->get();
	}

  /**
   * Scope for completed events
   */

	public function scopeCompleted($query)
	{
		$constraint = date('Y-m-d', time());
		return $query->where('dateStart', '<', $constraint)->orderBy('dateStart', 'DESC')->get();
	}
	

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
	
  /**
   * Accessor 'getNumber'
   */

  public function getCourseNumberAttribute()
  {
    return $this->course->number . '.' . \Carbon\Carbon::parse($this->dateStart)->format('dmy');
  }
}
