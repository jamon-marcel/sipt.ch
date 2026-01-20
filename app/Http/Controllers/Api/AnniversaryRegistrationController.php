<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\AnniversaryRegistration;
use App\Models\User;
use App\Events\AnniversaryRegistration as AnniversaryRegistrationEvent;
use App\Http\Resources\DataCollection;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnniversaryRegistrationController extends Controller
{
  protected $registration;
  protected $user;

  public function __construct(AnniversaryRegistration $registration, User $user)
  {
    $this->registration = $registration;
    $this->user = $user;
  }

  /**
   * Get a list of registrations
   *
   * @return \Illuminate\Http\Response
   */
  public function get()
  {
    return new DataCollection(
      $this->registration
        ->orderBy('booking_number', 'DESC')
        ->where('is_cancelled', '=', 0)
        ->get()
    );
  }

  /**
   * Find a specific registration
   *
   * @param AnniversaryRegistration $registration
   * @return \Illuminate\Http\Response
   */
  public function find(AnniversaryRegistration $registration = null)
  {
    if ($registration) {
      return response()->json($registration);
    }
    return response()->json(null);
  }

  /**
   * Store a newly created registration (admin)
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $data = $request->input('registration');

    // Check for existing user and add 'user_id'
    $user = $this->user->where('email', '=', $data['email'])->get()->first();
    if ($user) {
      $data['user_id'] = $user->id;
    }

    // Check if registration already exists
    $existing = $this->registration->where('email', '=', $data['email'])->first();
    if ($existing) {
      abort(500, 'Anmeldung mit dieser E-Mail existiert bereits');
    }

    // Create booking number if not provided
    if (!isset($data['booking_number']) || !$data['booking_number']) {
      $data['booking_number'] = \BookingHelper::getNumber();
    }

    // Client number
    if (!isset($data['number']) || !$data['number']) {
      $data['number'] = \StudentHelper::getNumber();
    }

    // Calculate cost and early bird status
    $earlyBirdDeadline = Carbon::create(2026, 5, 30, 23, 59, 59);
    $isEarlyBird = Carbon::now()->lte($earlyBirdDeadline);
    $data['is_early_bird'] = $isEarlyBird ? 1 : 0;
    $data['cost'] = $this->calculateCost($data['ticket_type'], $isEarlyBird);

    // Create registration
    $registration = AnniversaryRegistration::create($data);
    $registration->save();

    // Event: Registration confirmation
    event(new AnniversaryRegistrationEvent($registration));

    return response()->json(true);
  }

  /**
   * Update a registration
   *
   * @param AnniversaryRegistration $registration
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function update(AnniversaryRegistration $registration, Request $request)
  {
    $data = $request->all();
    $registration->update($data);
    $registration->save();
    return response()->json('successfully updated');
  }

  /**
   * Cancel (soft delete) a registration
   *
   * @param AnniversaryRegistration $registration
   * @return \Illuminate\Http\Response
   */
  public function cancel(AnniversaryRegistration $registration)
  {
    if ($registration) {
      $registration->is_cancelled = 1;
      $registration->save();
    }
    return response()->json(true);
  }

  /**
   * Calculate cost based on ticket type and early bird status
   *
   * @param string $ticketType
   * @param bool $isEarlyBird
   * @return float
   */
  private function calculateCost($ticketType, $isEarlyBird)
  {
    $prices = [
      'both_days' => [
        'early_bird' => 350.00,
        'normal' => 390.00,
      ],
      'friday_only' => [
        'early_bird' => 150.00,
        'normal' => 150.00,
      ],
      'saturday_only' => [
        'early_bird' => 250.00,
        'normal' => 250.00,
      ],
    ];

    $priceKey = $isEarlyBird ? 'early_bird' : 'normal';
    return $prices[$ticketType][$priceKey] ?? 0;
  }
}
