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
		'is_active',
		'user_id',
	];

	protected $hidden = [
    'user_id', 'created_at', 'updated_at'
  ];
	
	public function user()
	{
		return $this->hasOne('App\Models\User', 'id', 'user_id');
	}

	public function invoices()
	{
		return $this->hasMany('App\Models\Invoice');
	}

  public function courseEvents($constraint = NULL)
  {
		if ($constraint == 'upcoming' || $constraint == 'booked')
		{
			return $this->belongsToMany('App\Models\CourseEvent')
									->orderBy('dateStart')
									->withPivot('has_attendance', 'booking_number', 'is_billed', 'is_invited', 'created_at')
									->where('dateStart', '>=', date('Y.m.d', time()));
		}
		else if ($constraint == 'completed')
		{
			return $this->belongsToMany('App\Models\CourseEvent')
									->orderBy('dateStart')
									->withPivot('has_attendance', 'booking_number', 'is_billed', 'is_invited', 'created_at')
									->where('is_closed', '=', 0)
									->where('dateStart', '<', date('Y.m.d', time()));
		}

		return $this->belongsToMany('App\Models\CourseEvent')
								->withPivot('has_attendance', 'booking_number', 'is_billed', 'is_invited', 'created_at')
								->orderBy('dateStart');
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