<?php
Namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class VipAddress extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
    'gender',
		'firstname',
    'name',
    'title',
    'role',
    'company',
    'department',
    'street',
    'street_no',
    'address_extra',
    'zip',
		'city',
		'country',
    'phone',
    'email',
    'mobile',
	];
	
  protected $appends = ['fullName'];
  
  /**
   * Accessor 'getFullName'
   */

  public function getFullNameAttribute()
  {
    return $this->firstname . ' ' . $this->name;
  }
}