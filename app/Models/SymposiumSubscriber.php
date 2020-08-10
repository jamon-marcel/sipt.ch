<?php
Namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class SymposiumSubscriber extends Model
{
  use SoftDeletes;
  
	protected $fillable = [
		'number',
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
		'cost',
		'has_attendance',
		'is_cancelled',
		'is_billed',
    'user_id',
		'symposium_id',
		'created_at'
	];

	protected $hidden = [
    'user_id', 'updated_at'
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
