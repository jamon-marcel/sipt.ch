<?php
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Specialisation extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
		'description',
		'sort'
	];

	public function courses()
	{
		return $this->belongsToMany('App\Models\Course');
	}

}
