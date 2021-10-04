<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class CourseSpecialisation extends Model
{
  protected $table = 'course_specialisation';

	protected $fillable = [
		'course_id',
		'specialisation_id',
  ];
  
	public function course()
	{
		return $this->hasOne('App\Models\Course');
  }
  
	public function specialisation()
	{
		return $this->hasOne('App\Models\Specialisation');
	}

}

