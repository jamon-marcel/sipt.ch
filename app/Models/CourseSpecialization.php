<?php
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class CourseSpecialization extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
		'description',
		'sort'
	];


}
