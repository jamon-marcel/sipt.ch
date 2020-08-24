<?php
namespace App\Listeners;
use App\Services\SymposiumInvoice;
use App\Events\SymposiumBill;
use App\Mail\SymposiumBillingNotification;
use App\Models\Symposium;
use App\Models\SymposiumSubscriber;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;

class SymposiumCreateSendBill
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct(Symposium $symposium, SymposiumSubscriber $symposiumSubscriber)
  {
    $this->symposium = $symposium;
    $this->symposiumSubscriber = $symposiumSubscriber;
  }

  /**
   * Handle the event.
   *
   * @param  SymposiumBill $event
   * @return void
   */
  public function handle(SymposiumBill $event)
  {
    // Get billable courses with billableStudents
    $symposiumSubscribers = $this->symposiumSubscriber->with('symposium')->billable();

    if ($symposiumSubscribers->count())
    {    
      $symposiumSubscribers = collect($symposiumSubscribers)->splice(0, 3);

      // Loop over all subscribers  
      foreach($symposiumSubscribers->all() as $subscriber)
      {
        // Create Invoice
        $invoice = $this->invoice($subscriber, $subscriber->symposium);

        // Notify User
        $this->notify($invoice, $subscriber, $subscriber->symposium);
      }
    }
  }

  /**
   * Create the invoice
   * 
   * @param $invoice
   * @return $invoice
   */
  
  public function invoice($subscriber, $symposium)
  {
    $invoice = new SymposiumInvoice();
    $invoice->create([
      'date'  => date('d.m.Y', time()),
      'amount' => $subscriber->cost,
      'client' => $subscriber,
      'booking_number' => $subscriber->booking_number,
      'symposium' => $symposium,
    ]);
          
    // Write to disk
    $invoice->write();

    // Store in database
    $invoice = $invoice->store();

    return $invoice;
  }

  /**
   * Send mail to student
   * 
   * @param $invoice
   * @return void
   */

  public function notify($invoice, $subscriber, $symposium)
  {
    Mail::to($subscriber->email)
          ->bcc(\Config::get('sipt.email_copy'))
          ->send(
              new SymposiumBillingNotification(
                [
                  'subscriber'      => $subscriber,
                  'symposium'       => $symposium,
                  'invoice_number'  => $invoice->number,
                  'invoice_amount'  => $invoice->amount,
                  'attachment'      => public_path() . '/storage/invoices/' . $invoice->file
                ]
          )
    );
  }
}
