<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class CourseEventStudent extends Model
{
	protected $table = 'course_event_student';

	protected $fillable = [
		'course_event_id',
		'student_id',
	];
	
	public function course()
	{
		return $this->hasOne('App\Models\Course');
	}
}
