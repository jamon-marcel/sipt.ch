<?php
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class CourseEventStudent extends Model
{
	use SoftDeletes;

	protected $table = 'course_event_student';

	protected $fillable = [
		'course_event_id',
		'student_id',
		'has_attendance',
		'booking_number'
	];
	
	public function course()
	{
		return $this->hasOne('App\Models\Course');
	}
}
