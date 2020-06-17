<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Course extends Model
{
	protected $fillable = [
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
		return $this->hasMany('App\Models\CourseEvent')->orderBy('dateStart');
	}

	/**
	 * Relationship for bookable events
	 */

	public function eventsBookable()
	{
		$deadline = date('Y-m-d', 
			strtotime(\Config::get('sipt.registration_deadline'))
		);

		return $this->hasMany('App\Models\CourseEvent')
								->orderBy('dateStart')
								->where('dateStart', '>=', $deadline)
								->where('is_published', '=', 1)
								->where('is_bookable', '=', 1);
	}
}
