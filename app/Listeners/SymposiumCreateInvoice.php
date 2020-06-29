<?php
namespace App\Listeners;
use App\Events\SymposiumConfirmSubscription;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SymposiumCreateInvoice
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

    // Generate invoice number
    $invoice_number = 'sipt-rechnung-fachtagung-' . $subscriber->id; 

    $subscriber->invoice_number = $invoice_number;
    $subscriber->save();

    // Create invoice
    $this->viewData['subscriber'] = $subscriber;
    $pdf = PDF::loadView('pdf.symposium.invoice', $this->viewData);

    // Set path & filename
    $path = public_path() . '/storage/invoices/';
    $file = $invoice_number . '.pdf';

    // Store invoice
    $pdf->save($path . '/' . $file);
  }
}
