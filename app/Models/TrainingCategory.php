<?php
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class TrainingCategory extends Model
{
  use SoftDeletes;
  
  protected $fillable = [
    'name',
    'name_short',
  ];

  public function training()
  {
    return $this->belongsTo('App\Models\Training');
  }
}
