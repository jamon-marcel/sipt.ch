<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class CourseTraining extends Model
{
	protected $table = 'course_training';

	protected $fillable = [
		'training_id',
		'course_id',
  ];
}
