<?php
Namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Student extends Model
{
	protected $fillable = [
		'firstname',
		'name',
		'phone',
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
}