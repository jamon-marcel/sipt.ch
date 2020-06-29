<?php
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Training extends Model
{
  use SoftDeletes;
  
	protected $fillable = [
    'title',
    'description',
    'description_short',
    'structure',
		'supervision',
    'thesis',
    'certification',
    'cost',
    'time',
    'location_id',
    'category_id',
    'is_cas',
    'is_published',
  ];

  public function courses()
  {
    return $this->belongsToMany('App\Models\Course');
  }

	public function location()
	{
		return $this->hasOne('App\Models\Location', 'id', 'location_id');
  }
  
	public function category()
	{
		return $this->hasOne('App\Models\TrainingCategory', 'id', 'category_id');
	}

}
