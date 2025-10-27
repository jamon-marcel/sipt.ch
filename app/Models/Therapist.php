<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Therapist extends Model
{
	protected $fillable = [
		'title',
		'firstname',
		'name',
		'country',
		'description',
		'order',
		'is_published',
	];

	protected $casts = [
		'is_published' => 'integer',
	];

	public function scopeActive($query)
	{
		return $query->where('is_published', '=', 1);
	}

	public function scopeByCountry($query, $country)
	{
		return $query->where('country', '=', $country);
	}
}
