<?php
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class PartnerInstitution extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'name',
		'description',
		'order',
		'is_published',
	];

	protected $casts = [
		'is_published' => 'integer',
	];

	/**
	 * Scope a query to only active partner institutions.
	 *
	 * @param  \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeActive($query)
	{
		return $query->where('is_published', '=', 1)->orderBy('order');
	}

	/**
	 * Scope a query to order by order field.
	 *
	 * @param  \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeOrdered($query)
	{
		return $query->orderBy('order');
	}
}
