<?php
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class CourseTraining extends Model
{
	use SoftDeletes;
	
	protected $table = 'course_training';

	protected $fillable = [
		'training_id',
		'course_id',
  ];
}
