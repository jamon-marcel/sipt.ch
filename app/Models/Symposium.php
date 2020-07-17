<?php
Namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Symposium extends Model
{
	use SoftDeletes;

  protected $table = 'symposiums';

	protected $fillable = [
    'title',
    'subtitle',
    'description',
    'date',
    'cost',
    'location',
    'is_archived',
    'is_published',
  ];
  
  /**
   * Relationship for all subscribers
   */
	public function subscribers()
	{
		return $this->hasMany('App\Models\SymposiumSubscriber')->orderBy('name');
  }
  
  /**
   * Relationship for all subscribers
   */
  
	public function invoices()
	{
		return $this->hasMany('App\Models\Invoice');
	}

  /**
   * Accessor 'getDate'
   */

  public function getDateAttribute($value)
  {
    return \Carbon\Carbon::parse($value)->format('d.m.Y');
  }

  /**
   * Accessor 'getTimeStart'
   */

  public function getTimeStartAttribute($value)
  {
    return \Carbon\Carbon::parse($this->attributes['timeStart'])->format('H.i');
  }

  /**
   * Accessor 'getTimeEnd'
   */

  public function getTimeEndAttribute($value)
  {
    return \Carbon\Carbon::parse($this->attributes['timeEnd'])->format('H.i');
  }

}
