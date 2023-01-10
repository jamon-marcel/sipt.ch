<?php
namespace App\Http\Controllers;
use App\Models\MailinglistSubscriber;
use App\Models\Mailinglist;
use App\Models\User;
use App\Actions\Mailinglist\RegisterSubscriber;
use App\Actions\Mailinglist\ConfirmSubscriber;
use App\Actions\Mailinglist\DeleteSubscription;
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
}
