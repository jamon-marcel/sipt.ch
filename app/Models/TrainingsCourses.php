<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class TrainingsCourses extends Model
{
	protected $fillable = [
		'training_id',
		'course_id',
  ];
}
