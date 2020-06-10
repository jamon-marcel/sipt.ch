<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Course extends Model
{
	protected $fillable = [
		'title',
		'description',
		'credits',
		'durability',
		'cost',
		'is_archived',
    'is_published',
	];
	
	public function trainings()
	{
		return $this->belongsToMany('App\Models\Training');
	}

	public function events()
	{
		return $this->hasMany('App\Models\CourseEvent')->orderBy('dateStart');
	}
}
