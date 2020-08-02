<?php
namespace App\Http\Controllers;
use App\Models\Symposium;
use App\Models\SymposiumSubscriber;
use App\Models\User;
use App\Events\SymposiumSubscription;
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

    // Create subscriber
    $subscriber = SymposiumSubscriber::create($data);
    $subscriber->save();

    // Event: Subscription confirmation
    event(new SymposiumSubscription($subscriber));

    return redirect()->route('symposium_register_success');
  }

  /**
   * Cancel a booking
   * @todo: implement withdrawal process
   *
   * @param SymposiumSubscriber $symposiumSubscriber
   * @return \Illuminate\Http\Response
   */

  public function cancel(SymposiumSubscriber $symposiumSubscriber)
  {
    if ($symposiumSubscriber)
    {
      $symposiumSubscriber->delete();
    }
    return redirect()->route('symposium_cancelled');
  }

}
