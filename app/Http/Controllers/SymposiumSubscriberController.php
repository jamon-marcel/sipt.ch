<?php
namespace App\Http\Controllers;
use App\Models\Symposium;
use App\Models\SymposiumSubscriber;
use App\Models\User;
use App\Events\SymposiumSubscription;
use App\Events\SymposiumCancelled;
use App\Services\Withdrawal;
use App\Http\Requests\SymposiumSubscriberStoreRequest;
use Illuminate\Http\Request;

class SymposiumSubscriberController extends Controller
{

  public function __construct(Symposium $symposium, SymposiumSubscriber $symposiumSubscriber, User $user)
  {
    $this->symposium = $symposium;
    $this->symposiumSubscriber = $symposiumSubscriber;
    $this->user = $user;
  }

  /**
   * Store a newly created subscriber
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(SymposiumSubscriberStoreRequest $request)
  {
    // Get request data
    $data = $request->all();

    // Check for existing user and add 'user_id'
    $user = $this->user->where('email', '=', $request->input('email'))->get()->first();
    if ($user)
    {
      $data['user_id'] = $user->id;
    }
    
    // Create booking number
    $data['booking_number'] = \BookingHelper::getNumber();

    // Client number
    $data['number'] = \StudentHelper::getNumber();

    // Cost
    $data['cost'] = '0.00';

    // Create subscriber
    $subscriber = SymposiumSubscriber::create($data);
    $subscriber->save();

    // Event: Subscription confirmation
    event(new SymposiumSubscription($subscriber));

    return redirect()->route('symposium_register_success');
  }

  /**
   * Cancel a booking
   *
   * @param SymposiumSubscriber $symposiumSubscriber
   * @return \Illuminate\Http\Response
   */

  public function cancel(SymposiumSubscriber $symposiumSubscriber)
  {
    $symposium  = $this->symposium->find(\Config::get('sipt.symposium_id'));
    $withdrawal = new Withdrawal();
    $penalty    = $withdrawal->getSymposiumCharges();

    if ($symposiumSubscriber)
    {
      $symposiumSubscriber->is_cancelled = 1;
      $symposiumSubscriber->is_billed = 1;
      $symposiumSubscriber->save();

      // Confirm cancellation
      event(new SymposiumCancelled($symposiumSubscriber, $symposium, $penalty));
    }

    return redirect()->route('symposium_cancelled');
  }

}
