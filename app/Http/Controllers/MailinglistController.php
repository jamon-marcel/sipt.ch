<?php
namespace App\Http\Controllers;
use App\Models\MailinglistSubscriber;
use App\Models\Mailinglist;
use App\Models\MailinglistSubscriberLog;
use App\Models\User;
use App\Actions\Mailinglist\RegisterSubscriber;
use App\Actions\Mailinglist\ConfirmSubscriber;
use App\Actions\Mailinglist\DeleteSubscription;
use App\Actions\Mailinglist\DeleteSubscriptions;
use App\Http\Requests\MailinglistSubscriberStoreRequest;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class MailinglistController extends BaseController
{
  protected $viewPath = 'web.pages.mailinglist.';

  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Show the mailinglist index page
   *
   * @return \Illuminate\Http\Response
   */

  public function index()
  { 
    return view($this->viewPath . 'index');
  }

  /**
   * Store a newly created subscriber
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */

  public function register(MailinglistSubscriberStoreRequest $request, RegisterSubscriber $registerSubscriber)
  {
    $registerSubscriber->execute(
      $request->input('mailinglists'), 
      $request->input('email')
    );
    return view($this->viewPath . 'index', ['message' => 'pending_confirmation']);
  }

  /**
   * Show the mailinglist confirm page
   *
   * @param MailinglistSubscriber $mailinglistSubscriber
   * @return \Illuminate\Http\Response
   */

  public function confirm(MailinglistSubscriber $mailinglistSubscriber, ConfirmSubscriber $confirmSubscriber)
  { 
    $confirmSubscriber->execute($mailinglistSubscriber);
    return view($this->viewPath . 'index', ['message' => 'confirmed']);
  }

  /**
   * Show the mailinglist cancelled page
   *
   * @param MailinglistSubscriber $mailinglistSubscriber
   * @return \Illuminate\Http\Response
   */

  public function cancel(MailinglistSubscriber $mailinglistSubscriber, DeleteSubscription $deleteSubscription)
  { 
    $deleteSubscription->execute($mailinglistSubscriber);
    return view($this->viewPath . 'cancel');
  }

  /**
   * Manage the mailinglist subscriptions for a subscriber
   * 
   * @param MailinglistSubscriber $mailinglistSubscriber
   * @return \Illuminate\Http\Response
   */ 
   
  public function manage(MailinglistSubscriber $mailinglistSubscriber)
  {
    // 1. get all subscriptions for this subscriber
    $subscriptions = MailinglistSubscriber::where('email', $mailinglistSubscriber->email)->get();
    $subscriptions = $subscriptions->pluck('mailinglist_id')->toArray();

    // 2. get all mailinglists
    $mailinglists = Mailinglist::all();

    // 3. log access
    $user = User::where('email', $mailinglistSubscriber->email)->first();
    MailinglistSubscriberLog::create([
      'email' => $mailinglistSubscriber->email,
      'action' => 'manage',
      'is_user' => $user ? 1 : 0
    ]);
    return view($this->viewPath . 'manage', ['subscriptions' => $subscriptions, 'subscriber' => $mailinglistSubscriber->email]);
  }

  /**
   * Udpate a subscriber's subscriptions
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */

   public function update(Request $request, RegisterSubscriber $registerSubscriber, DeleteSubscriptions $deleteSubscriptions)
   {
      $deleteSubscriptions->execute($request->input('email'));
      $registerSubscriber->execute(
        $request->input('mailinglists'), 
        $request->input('email'),
        TRUE
      );

      $user = User::where('email', $request->input('email'))->first();
      MailinglistSubscriberLog::create([
        'email' => $request->input('email'),
        'action' => 'update',
        'is_user' => $user ? 1 : 0
      ]);

      return view($this->viewPath . 'index', ['message' => 'lists_updated']);
   }
}
