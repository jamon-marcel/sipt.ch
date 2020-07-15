<?php
namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Administrator extends Model
{
	protected $fillable = [
		'firstname',
		'name',
		'title',
		'street',
		'street_no',
		'zip',
		'city',
		'phone',
		'mobile',
		'user_id',
	];

	protected $hidden = [
    'user_id', 'created_at', 'updated_at'
  ];

	public function user()
	{
		return $this->hasOne('App\Models\User', 'id', 'user_id');
	}

  /**
   * Accessor 'getFullName'
   */

  public function getFullNameAttribute()
  {
    return $this->firstname . ' ' . $this->name;
  }
}
