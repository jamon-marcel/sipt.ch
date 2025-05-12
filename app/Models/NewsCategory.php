<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class NewsCategory extends Model
{
  protected $fillable = [
    'title'
  ];

  public function articles()
  {
    return $this->hasMany(NewsArticle::class);
  }
}
