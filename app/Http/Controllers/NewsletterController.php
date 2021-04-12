<?php
namespace App\Http\Controllers;
use App\Models\NewsletterSubscriber;
use App\Models\User;
use App\Http\Requests\NewsletterSubscriberStoreRequest;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class NewsletterController extends BaseController
{
  protected $viewPath = 'web.pages.newsletter.';

  public function __construct(NewsletterSubscriber $newsletterSubscriber, User $user)
  {
    parent::__construct();
    $this->newsletterSubscriber = $newsletterSubscriber;
    $this->user = $user;
  }


  /**
   * Show the newsletter index page
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
  public function register(NewsletterSubscriberStoreRequest $request)
  {
    // Check for existing subscriber
    $subscriber = $this->newsletterSubscriber->withTrashed()->where('email', '=', $request->input('email'))->get()->first();

    if ($subscriber)
    {
      $subscriber->deleted_at = NULL;
      $subscriber->is_confirmed = 1;
      $subscriber->save();
      return view($this->viewPath . 'index');
    }

    // Otherwise create new subscriber
    $data = [
      'email' => $request->input('email'),
      'is_done' => 1,
      'is_confirmed' => 0
    ];

    $subscriber = NewsletterSubscriber::create($data);
    $subscriber->save();

    // Send confirmation email
    \Mail::to($request->input('email'))
      ->send(
        new \App\Mail\NewsletterConfirm(
          [
            'subscriber'  => $subscriber,
          ]
      )
    );

    return view($this->viewPath . 'index', ['message' => 'pending_confirmation']);
  }

  /**
   * Show the newsletter confirm page
   *
   * @param NewsletterSubscriber $newsletterSubscriber
   * @return \Illuminate\Http\Response
   */

  public function confirm(NewsletterSubscriber $newsletterSubscriber)
  { 
    $newsletterSubscriber = $this->newsletterSubscriber->findOrFail($newsletterSubscriber->id);
    $newsletterSubscriber->is_confirmed = 1;
    $newsletterSubscriber->save();
    return view($this->viewPath . 'index', ['message' => 'confirmed']);
  }

  /**
   * Show the newsletter cancelled page
   *
   * @param NewsletterSubscriber $newsletterSubscriber
   * @return \Illuminate\Http\Response
   */

  public function cancel(NewsletterSubscriber $newsletterSubscriber)
  { 
    $newsletterSubscriber = $this->newsletterSubscriber->findOrFail($newsletterSubscriber->id);
    $newsletterSubscriber->delete();
    return view($this->viewPath . 'cancel');
  }

  /**
   * Import addresses from users table
   * 
   * @return void
   */
  public function import()
  {
    $users = $this->user->where('is_newsletter_subscriber', '=', '1')->get();
    if ($users)
    {
      foreach($users as $u)
      {
        $subscriber = $this->newsletterSubscriber->where('email', '=', $u->email)->get()->first();
        if ($subscriber === null)
        {
          $data = [
            'email' => $u->email,
            'is_done' => 1,
            'is_confirmed' => 1
          ];
          $newsletter_subscriber = NewsletterSubscriber::create($data);
          $newsletter_subscriber->save();
        }
      }
    }
  }
}
