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
		'bio',
		'publications',
    'image',
    'is_published',
		'user_id',
	];
	
	public function user()
	{
		return $this->hasOne('App\Models\User', 'id', 'user_id');
	}

	public function courseEvents()
	{
		return $this->hasMany('App\Models\StudentCourseEvent');
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
}