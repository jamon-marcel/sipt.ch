<?php
namespace App\Listeners;
use App\Events\SymposiumConfirmSubscription;
use App\Mail\SymposiumSubscriptionConfirmation;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SymposiumNotifySubscriber
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  /**
   * Handle the event.
   *
   * @param  SymposiumConfirmSubscription  $event
   * @return void
   */
  public function handle(SymposiumConfirmSubscription $event)
  {
    $subscriber = $event->symposiumSubscriber;

    $files = [
      public_path() . '/storage/invoices/' . 'sipt-rechnung-fachtagung-' . $subscriber->id . '.pdf',
      public_path() . '/storage/downloads/' . 'sipt-lageplan.pdf',
    ];

    Mail::to($subscriber->email)
          ->cc([\Config::get('sipt.email_cc')])
          ->send(
              new SymposiumSubscriptionConfirmation(
                [
                  'subscriber' => $subscriber,
                  'symposium' => $subscriber->symposium,
                  'files' => $files
                ]
          )
    );
  }
}
