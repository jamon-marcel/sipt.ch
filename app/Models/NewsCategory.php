<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class NewsCategory extends Model
{
  protected $fillable = [
    'title',
    'order',
    'is_published'
  ];

  public function articles()
  {
    return $this->hasMany(NewsArticle::class, 'category_id', 'id')->orderBy('order');
  }

  public function publishedArticles()
  {
    return $this->hasMany(NewsArticle::class, 'category_id', 'id')->orderBy('order')->where('is_published', '=', 1);
  }

  public function scopeActive($query)
	{
		return $query->where('is_published', '=', 1);
	}
}
