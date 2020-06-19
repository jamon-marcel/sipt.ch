<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class TutorImage extends Model
{
	protected $fillable = [
		'name',
    'caption',
		'coords_w',
    'coords_h',
    'coords_x',
    'coords_y',
    'orientation',
    'publish',
    'tutor_id',
	];

  public function tutor()
  {
    return $this->belongsTo('App\Models\Tutor');
  }
}