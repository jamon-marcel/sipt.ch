<?php
namespace App\Http\Controllers;
use App\Models\Symposium;
use App\Models\SymposiumSubscriber;
use App\Models\User;
use App\Events\SymposiumConfirmSubscription;
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

    // Create subscriber    
    $data['booking_number'] = SymposiumSubscriber::max('booking_number') + 1;
    $subscriber = SymposiumSubscriber::create($data);
    $subscriber->save();

    // Event: Subscription confirmation
    event(new SymposiumConfirmSubscription($subscriber));

    // Delete for testing
    $subscriber->forceDelete();

    return redirect()->route('symposium_register_success');
  }

}
