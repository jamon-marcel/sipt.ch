<?php
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Course extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
		'number',
		'title',
		'description',
		'credits',
		'durability',
		'cost',
		'is_archived',
    'is_published',
	];
	
	/**
	 * Relationship for trainings
	 */

	public function trainings()
	{
		return $this->belongsToMany('App\Models\Training');
	}

	/**
	 * Relationship for all events
	 */

	public function events()
	{
		return $this->hasMany('App\Models\CourseEvent')
								->orderBy('dateStart');
	}

	/**
	 * Relationship for all upcoming events
	 */

	public function eventsUpcoming()
	{
		$constraint = date('Y-m-d', time());
		return $this->hasMany('App\Models\CourseEvent')
								->orderBy('dateStart')
								->where('dateStart', '>=', $constraint);
	}

	/**
	 * Relationship for all completed events
	 */

	public function eventsCompleted()
	{
		$constraint = date('Y-m-d', time());
		return $this->hasMany('App\Models\CourseEvent')
								->orderBy('dateStart')
								->where('dateStart', '<', $constraint)
								->where('is_closed', '=', 0);
	}

	/**
	 * Relationship for all closed events
	 */

	public function eventsClosed()
	{
		$constraint = date('Y-m-d', time());
		return $this->hasMany('App\Models\CourseEvent')
								->orderBy('dateStart')
								->where('dateStart', '<', $constraint)
								->where('is_closed', '=', 1);
	}

	/**
	 * Relationship for bookable events
	 */

	public function eventsBookable()
	{
		$constraint = date('Y-m-d', 
			strtotime(\Config::get('sipt.registration_deadline'))
		);

		return $this->hasMany('App\Models\CourseEvent')
								->orderBy('dateStart')
								->where('dateStart', '>=', $constraint)
								->where('is_published', '=', 1)
								->where('is_bookable', '=', 1);
	}

	public function specialisations()
	{
		return $this->belongsToMany('App\Models\Specialisation');
	}

}
