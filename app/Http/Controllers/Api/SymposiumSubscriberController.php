<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Symposium;
use App\Models\SymposiumSubscriber;
use App\Models\Student;
use App\Models\User;
use App\Events\SymposiumSubscription;
use App\Services\Withdrawal;
use App\Events\SymposiumCancelled;
use App\Http\Requests\SymposiumSubscriberStoreRequest;
use App\Http\Resources\DataCollection;
use Illuminate\Http\Request;

class SymposiumSubscriberController extends Controller
{

  public function __construct(Symposium $symposium, SymposiumSubscriber $symposiumSubscriber, User $user, Student $student)
  {
    $this->symposium = $symposium;
    $this->symposiumSubscriber = $symposiumSubscriber;
    $this->student = $student;
    $this->user = $user;
  }

  /**
   * Get a list of subscribers
   * 
   * @return \Illuminate\Http\Response
   */
  public function get()
  {
    return new DataCollection($this->symposiumSubscriber->orderBy('booking_number', 'DESC')->where('is_cancelled', '=', 0)->get());
  }

  /**
   * Store a newly created subscriber
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    // Get request data
    $data = $request->all();

    if (isset($data['subscriberId']) && $data['subscriberId'] != null)
    {
      $student = $this->student->with('user')->findOrFail($data['subscriberId']);
      $insert_data = [
        'number' => $student->number,
        'name' => $student->name,
        'firstname' => $student->firstname,
        'title' => $student->title,
        'qualifications' => $student->qualifications,
        'street' => $student->street,
        'street_no' => $student->street_no,
        'zip' => $student->zip,
        'city' => $student->city,
        'country' => $student->country,
        'phone' => $student->phone,
        'phone_business' => $student->phone_business,
        'mobile' => $student->mobile,
        'email' => $student->user->email,
        'user_id' => $student->user->id,
        'symposium_id' => '644b0723-5c3a-45d3-800a-592876d90257',
        'booking_number' => $data['booking_number'],
        'cost' => \MoneyFormatHelper::number('200'),
        'created_at' => $data['created_at'],
      ];

      $existing = $this->symposiumSubscriber->where('email', '=', $student->user->email)->get()->first();
      if ($existing)
      {
        abort(500, 'Subscriber exists');
      }
      else
      {
        // Create subscriber
        $subscriber = SymposiumSubscriber::create($insert_data);
        $subscriber->save();
      }
    }
    else
    {
      $insert_data = [
        'number' => \StudentHelper::getNumber(),
        'name' => $data['subscriber']['name'],
        'firstname' => $data['subscriber']['firstname'],
        'title' => $data['subscriber']['title'],
        'qualifications' => $data['subscriber']['qualifications'],
        'street' => $data['subscriber']['street'],
        'street_no' => $data['subscriber']['street_no'],
        'zip' => $data['subscriber']['zip'],
        'city' => $data['subscriber']['city'],
        'country' => $data['subscriber']['country'],
        'phone' => $data['subscriber']['phone'],
        'email' => $data['subscriber']['email'],
        'phone_business' => $data['subscriber']['phone_business'],
        'mobile' => $data['subscriber']['mobile'],
        'symposium_id' => '644b0723-5c3a-45d3-800a-592876d90257',
        'booking_number' => $data['booking_number'],
        'cost' => \MoneyFormatHelper::number('200'),
        'created_at' => $data['created_at'],
      ];

      // Check for existing user and add 'user_id'
      $user = $this->user->where('email', '=', $data['subscriber']['email'])->get()->first();
      if ($user)
      {
        $insert_data['user_id'] = $user->id;
      }

      $existing = $this->symposiumSubscriber->where('email', '=', $insert_data['email'])->get()->first();
      if ($existing)
      {
        abort(500, 'Subscriber exists');
      }
      else
      {
        // Create subscriber
        $subscriber = SymposiumSubscriber::create($insert_data);
        $subscriber->save();
      }

    }

    // Event: Subscription confirmation
    // event(new SymposiumSubscription($subscriber));

    return response()->json(true); 
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
    $symposium  = $this->symposium->find(\Config::get('sipt.symposium_id'));
    $withdrawal = new Withdrawal();
    $penalty    = $withdrawal->getSymposiumCharges();

    if ($symposiumSubscriber)
    {
      $symposiumSubscriber->is_cancelled = 1;
      $symposiumSubscriber->is_billed = 1;
      $symposiumSubscriber->save();

      // Fire cancel event
      event(new SymposiumCancelled($symposiumSubscriber, $symposium, $penalty));

    }

    return response()->json(true);
  }
}
