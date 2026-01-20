<?php
namespace App\Http\Controllers;
use App\Models\AnniversaryRegistration;
use App\Events\AnniversaryRegistration as AnniversaryRegistrationEvent;
use App\Http\Requests\AnniversaryRegistrationStoreRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnniversaryRegistrationController extends Controller
{
  /**
   * Store a newly created registration
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(AnniversaryRegistrationStoreRequest $request)
  {
    // Get request data
    $data = $request->all();

    // Create booking number
    $data['booking_number'] = \BookingHelper::getNumber();

    // Determine if early bird (before 30.05.2026)
    $earlyBirdDeadline = Carbon::create(2026, 5, 30, 23, 59, 59);
    $isEarlyBird = Carbon::now()->lte($earlyBirdDeadline);
    $data['is_early_bird'] = $isEarlyBird ? 1 : 0;

    // Calculate cost based on ticket type and early bird status
    $data['cost'] = $this->calculateCost($data['ticket_type'], $isEarlyBird);

    // Create registration
    $registration = AnniversaryRegistration::create($data);
    $registration->save();

    // Event: Registration confirmation
    event(new AnniversaryRegistrationEvent($registration));

    return redirect()->route('anniversary_register_success');
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
