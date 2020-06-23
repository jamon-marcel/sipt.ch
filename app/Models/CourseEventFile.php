<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class CourseEventFile extends Model
{
	protected $fillable = [
		'name',
    'caption',
    'size',
    'type',
    'tutor_id',
    'course_event_id',
	];

  public function tutor()
  {
    return $this->belongsTo('App\Models\Tutor');
  }

  public function courseEvent()
  {
    return $this->belongsTo('App\Models\CourseEvent');
  }

}