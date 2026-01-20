<?php
Namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class AnniversaryRegistration extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'booking_number',
    'salutation',
    'firstname',
    'name',
    'title',
    'email',
    'phone',
    'street',
    'street_no',
    'zip',
    'city',
    'ticket_type',
    'cost',
    'apero_friday',
    'lunch_saturday',
    'is_early_bird',
    'is_cancelled',
    'created_at'
  ];

  protected $hidden = [
    'updated_at'
  ];

  protected $casts = [
    'apero_friday' => 'boolean',
    'lunch_saturday' => 'boolean',
    'is_early_bird' => 'boolean',
    'is_cancelled' => 'boolean',
  ];

  public function invoices()
  {
    return $this->hasMany('App\Models\Invoice', 'anniversary_registration_id', 'id');
  }

  public function invoice()
  {
    return $this->hasOne('App\Models\Invoice', 'anniversary_registration_id', 'id');
  }

  /**
   * Scope for billable registrations
   */
  public function scopeBillable($query)
  {
    return $query->where('is_cancelled', '=', 0)->where('cost', '>', 0)->get();
  }

  /**
   * Accessor 'getFullName'
   */
  public function getFullNameAttribute()
  {
    return $this->firstname . ' ' . $this->name;
  }

  /**
   * Get ticket type label
   */
  public function getTicketTypeLabelAttribute()
  {
    $labels = [
      'both_days' => 'Beide Tage (Fr + Sa)',
      'friday_only' => 'Nur Freitag, 21.8.26',
      'saturday_only' => 'Nur Samstag, 22.8.26',
    ];
    return $labels[$this->ticket_type] ?? $this->ticket_type;
  }
}
