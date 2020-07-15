<?php
Namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Invoice extends Model
{
	use SoftDeletes;

  protected $table = 'invoices';

	protected $fillable = [
    'number',
    'date',
    'state',
    'file',
    'is_paid',
    'course_event_id',
    'student_id'
  ];

	/**
	 * Relationship for student
	 */

	public function student()
	{
		return $this->belongsTo('App\Models\Student');
  }

	/**
	 * Relationship for event
	 */

	public function event()
	{
		return $this->belongsTo('App\Models\CourseEvent');
  }
  
  /**
   * Mutator 'setDate'
   */

  public function setDateAttribute($value)
  {
    $this->attributes['date'] = \Carbon\Carbon::parse($value)->format('Y.m.d');
  }

  /**
   * Accessor 'getDate'
   */

  public function getDateAttribute($value)
  {
    return \Carbon\Carbon::parse($value)->format('d.m.Y');
  }
}
