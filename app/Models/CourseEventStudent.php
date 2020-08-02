<?php
namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class CourseEventStudent extends Model
{
	use SoftDeletes;

	protected $table = 'course_event_student';

	protected $fillable = [
		'course_event_id',
		'student_id',
		'has_attendance',
		'has_confirmation',
		'booking_number',
		'is_invited',
		'is_billed',
		'is_cancelled',
		'cancelled_at',
		'created_at'
	];
	
	public function course()
	{
		return $this->hasOne('App\Models\Course');
	}

  /**
   * Mutator 'setDate'
   */

  public function setCancelledAtAttribute($value)
  {
    $this->attributes['cancelled_at'] = \Carbon\Carbon::parse($value)->format('Y.m.d');
	}
	
  /**
   * Accessor 'getDate'
   */

  public function getCancelledAtAttribute($value)
  {
    return \Carbon\Carbon::parse($value)->format('d.m.Y');
  }
}
