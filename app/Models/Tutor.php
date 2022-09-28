<?php
Namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Tutor extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
		'firstname',
    'name',
    'title',
    'street',
    'street_no',
    'zip',
		'city',
		'country',
    'phone',
		'mobile',
		'description',
		'emphasis',
		'publications',
    'media',
		'image',
		'is_leader',
    'is_published',
    'is_visible',
		'user_id',
	];
	
	protected $appends = ['fullName'];

	
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
			return $this->hasMany('App\Models\CourseEventDate')->where('date', '>=', date('Y.m.d', time()))->orderBy('date');
		}
		else if ($constraint == 'past')
		{
			return $this->hasMany('App\Models\CourseEventDate')->where('date', '<', date('Y.m.d', time()))->orderBy('date');
		}
		return $this->hasMany('App\Models\CourseEventDate')->orderBy('date');
	}

	/**
	 * Scope a query to only active tutors.
	 *
	 * @param  \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */

	public function scopeActive($query)
	{
		return $query->where('is_published', '=', 1)->orderBy('name');
	}

	/**
	 * Scope a query to only active & published tutors.
	 *
	 * @param  \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */

	public function scopeActiveAndVisible($query)
	{
		return $query->where('is_published', '=', 1)->where('is_visible', '=', 1)->orderBy('name');
	}
	
	
	/**
	 * Scope a query to only tutors marked as leader.
	 *
	 * @param  \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */

	public function scopeLeader($query)
	{
		return $query->where('is_leader', '=', 1)->orderBy('name');
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

  /**
   * Accessor 'getFullName'
   */

  public function getFullNameAttribute()
  {
    return $this->firstname . ' ' . $this->name;
  }

}