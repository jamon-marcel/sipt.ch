<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Training extends Model
{
	protected $fillable = [
    'title',
    'description',
		'structure',
		'supervision',
    'final_assignment',
    'certification',
    'is_cas',
    'is_published',
  ];

  public function courses()
  {
    return $this->belongsToMany('App\Models\Course');
  }

}
