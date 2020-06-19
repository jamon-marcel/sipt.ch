<?php
Namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Tutor extends Model
{
	protected $fillable = [
		'firstname',
    'name',
    'title',
    'street',
    'street_no',
    'zip',
    'city',
    'phone',
    'mobile',
		'emphasis',
		'publications',
    'image',
    'is_published',
		'user_id',
	];
	
	public function user()
	{
		return $this->hasOne('App\Models\User', 'id', 'user_id');
	}

	public function images()
	{
		return $this->hasMany('App\Models\TutorImage');
	}

	public function courseEventDates($constraint = NULL)
	{
		if ($constraint == 'upcoming')
		{
			return $this->hasMany('App\Models\CourseEventDate')->where('date', '>=', date('Y.m.d', time()));
		}

		return $this->hasMany('App\Models\CourseEventDate');
	}

	/**
	 * Scope a query to only active tutors.
	 *
	 * @param  \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */

	public function scopeActive($query)
	{
		return $query->where('is_published', '=', 1);
	}
	
	/**
	 * Scope a query to get the authenticated tutor.
	 *
	 * @param  \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */

	public function scopeAuthenticated($query, $id)
	{
		return $query->where('user_id', '=', $id)->get()->first();
	}
}