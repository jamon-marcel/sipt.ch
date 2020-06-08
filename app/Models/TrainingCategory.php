<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class TrainingCategory extends Model
{
  protected $fillable = [
    'name',
    'name_short',
  ];

  public function training()
  {
    return $this->belongsTo('App\Models\Training');
  }
}
