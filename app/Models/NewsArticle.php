<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class NewsArticle extends Model
{
	protected $fillable = [
		'title',
    'date',
    'text',
    'link',
    'order',
    'is_published',
    'tutor_id',
    'tutors',
    'category_id'
  ];

  public function category()
  {
    return $this->belongsTo(NewsCategory::class);
  }

  public function tutor()
  {
    return $this->belongsTo(Tutor::class);
  }

  public function scopeActive($query)
	{
		return $query->where('is_published', '=', 1);
	}
}
