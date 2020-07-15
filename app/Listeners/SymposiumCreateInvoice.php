<?php
namespace App\Listeners;
use App\Events\SymposiumConfirmSubscription;
use App\Services\PaymentSlip;
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

    $client_number          = '0000';
    $invoice_number         = 605277;
    $invoice_reservation_no = str_pad($subscriber->booking_number, 6, "0", STR_PAD_LEFT);
    $invoice_amount         = $subscriber->symposium->cost;

    $paymentSlip = new PaymentSlip('0000',  $invoice_reservation_no, $invoice_number, $invoice_amount);
    $this->viewData['invoice'] =  $paymentSlip->get();


    // Generate invoice number
    $invoice_number = 'sipt-rechnung-fachtagung-' . $subscriber->id; 

    // Create invoice
    $this->viewData['subscriber'] = $subscriber;
    $pdf = PDF::loadView('pdf.invoice.symposium', $this->viewData);

    // Set path & filename
    $path = public_path() . '/storage/invoices/';
    $file = $invoice_number . '.pdf';

    // Store invoice
    $pdf->save($path . '/' . $file);
  }
}
