<?php
Namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Student extends Model
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
		'phone_business',
		'mobile',
		'qualifications',
		'alt_company',
		'alt_name',
		'alt_street',
		'alt_street_no',
		'alt_zip',
		'alt_city',
		'needs_credit_confirmation',
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

  public function courseEvents()
  {
    return $this->belongsToMany('App\Models\CourseEvent')->orderBy('dateStart');
	}

	public function scopeAuthenticated($query, $id)
	{
		return $query->where('user_id', '=', $id)->get()->first();
	}  
}