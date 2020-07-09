<?php
Namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Student extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
		'number',
		'firstname',
		'name',
		'title',
		'training',
		'street',
		'street_no',
		'zip',
		'city',
		'country',
		'phone',
		'phone_business',
		'mobile',
		'qualifications',
		'alt_company',
		'alt_name',
		'alt_street',
		'alt_street_no',
		'alt_zip',
		'alt_city',
		'needs_hours_confirmation',
		'has_alt_address',
		'user_id',
	];

	protected $hidden = [
    'user_id', 'created_at', 'updated_at'
  ];
	
	public function user()
	{
		return $this->hasOne('App\Models\User', 'id', 'user_id');
	}

  public function courseEvents($constraint = NULL)
  {
		if ($constraint == 'upcoming')
		{
			return $this->belongsToMany('App\Models\CourseEvent')
									->orderBy('dateStart')
									->where('dateStart', '>=', date('Y.m.d', time()));
		}
		return $this->belongsToMany('App\Models\CourseEvent')->orderBy('dateStart');
	}

	/**
	 * Scope a query to get the authenticated student.
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