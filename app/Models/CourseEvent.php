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
		'is_closed',
	];

	protected $appends = ['courseNumber'];

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
	
	public function invoices()
	{
		return $this->hasMany('App\Models\Invoice')->orderBy('number');
	}

	public function students()
	{
		return $this->belongsToMany('App\Models\Student')
								->withPivot('has_attendance', 'booking_number', 'is_billed', 'is_invited', 'created_at')
								->where('is_cancelled', '=', 0);
	}

	public function billableStudents()
	{
		return $this->belongsToMany('App\Models\Student')
								->with('user')
								->withPivot('has_attendance', 'booking_number', 'is_billed')
								->where('is_cancelled', '=', 0)
								->where('is_billed', '=', 0);
	}

	public function callableStudents()
	{
		return $this->belongsToMany('App\Models\Student')
								->with('user')
								->withPivot('booking_number', 'is_invited')
								->where('is_cancelled', '=', 0)
								->where('is_invited', '=', 0);
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
   * Scope for billable events (send invoices)
   */

	public function scopeBillable($query)
	{
		$constraint = date('Y-m-d', strtotime(\Config::get('sipt.billable_deadline')));
		return $query->where('dateStart', '<=', $constraint)->get();
	}

  /**
   * Scope for callable events (send invitations)
   */

	public function scopeCallable($query)
	{
		$constraint = date('Y-m-d', strtotime(\Config::get('sipt.callable_deadline')));
		return $query->where('dateStart', '<=', $constraint)->get();
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
