<?php

namespace App\Models;

use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class TherapistIntro extends Model
{
	protected $fillable = [
		'content',
		'is_published',
	];

	protected $casts = [
		'is_published' => 'integer',
	];
}
