<?php
Namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class SymposiumSubscriber extends Model
{
  use SoftDeletes;
  
	protected $fillable = [
		'firstname',
		'name',
		'title',
		'street',
		'street_no',
		'zip',
		'city',
		'country',
    'email',
    'phone',
		'phone_business',
		'mobile',
		'qualifications',
		'booking_number',
    'user_id',
    'symposium_id',
	];

	protected $hidden = [
    'user_id', 'created_at', 'updated_at'
  ];

  public function symposium()
  {
    return $this->belongsTo('App\Models\Symposium');
	}

	public function invoices()
	{
		return $this->hasMany('App\Models\Invoice');
	}

  /**
   * Accessor 'getFullName'
   */

  public function getFullNameAttribute()
  {
    return $this->firstname . ' ' . $this->name;
  }
}
