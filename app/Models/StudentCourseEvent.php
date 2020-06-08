<?php
Namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class StudentCourseEvent extends Model
{
	protected $fillable = [
    'student_id',
    'course_event_id',
  ];

  public function student()
  {
    return $this->belongsTo('App\Models\Student');
  }

  public function courseEvents()
  {
    return $this->belongsToMany('App\Models\CourseEvents');
  }
}
