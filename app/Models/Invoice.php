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
    'amount',
    'date_notice',
    'date_paid',
    'state',
    'file',
    'is_paid',
    'is_replacement',
    'replaced_by',
    'course_event_id',
    'student_id',
    'symposium_subscriber_id',
    'symposium_id',
    'user_id',
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
		return $this->belongsTo('App\Models\CourseEvent', 'course_event_id', 'id');
  }

  public function replacement()
  {
    return $this->belongsTo('App\Models\invoice', 'replaced_by', 'id');
  }

	/**
	 * Relationship for symposiumSubscriber
	 */

	public function symposiumSubscriber()
	{
		return $this->belongsTo('App\Models\SymposiumSubscriber', 'symposium_subscriber_id', 'id');
  }

  /**
	 * Relationship for symposium
	 */

	public function symposium()
	{
		return $this->belongsTo('App\Models\Symposium', 'symposium_id', 'id');
  }

	/**
	 * Relationship for user
	 */

	public function user()
	{
		return $this->belongsTo('App\Models\User');
  }

  
  /**
   * Mutator 'setDate'
   */

  public function setDateAttribute($value)
  {
    $this->attributes['date'] = \Carbon\Carbon::parse($value)->format('Y.m.d');
  }

  /**
   * Mutator 'setDateNotice'
   */

  public function setDateNoticeAttribute($value)
  {
    $this->attributes['date_notice'] = \Carbon\Carbon::parse($value)->format('Y.m.d');
  }

  /**
   * Mutator 'setDatePaid'
   */

  public function setDatePaidAttribute($value)
  {
    $this->attributes['date_paid'] = $value ? \Carbon\Carbon::parse($value)->format('Y.m.d') : null;
  }


  /**
   * Accessor 'getDate'
   */

  public function getDateAttribute($value)
  {
    return \Carbon\Carbon::parse($value)->format('d.m.Y');
  }

  /**
   * Accessor 'getDateNotice'
   */

  public function getDateNoticeAttribute($value)
  {
    return \Carbon\Carbon::parse($value)->format('d.m.Y');
  }

  /**
   * Accessor 'getDatePaid'
   */

  public function getDatePaidAttribute($value)
  {
    return \Carbon\Carbon::parse($value)->format('d.m.Y');
  }
}
