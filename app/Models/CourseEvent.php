<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class CourseEvent extends Model
{
	protected $fillable = [
		'course_id',
	];
	
	public function dates()
	{
		return $this->hasMany('App\Models\CourseEventDate');
	}
}
