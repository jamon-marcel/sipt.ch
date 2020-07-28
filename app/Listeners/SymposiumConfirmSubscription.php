<?php
namespace App\Listeners;
use App\Events\SymposiumSubscription;
use App\Models\Invoice;
use App\Services\PaymentSlip;
use App\Mail\SymposiumSubscriptionConfirmation;
use PDF;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SymposiumConfirmSubscription
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
   * @param  SymposiumSubscription  $event
   * @return void
   */
  public function handle(SymposiumSubscription $event)
  {
    $subscriber = $event->symposiumSubscriber;

    // $invoiceNumber  = Invoice::withTrashed()->max('number') + 1;
    // $data = [
    //   'invoice_number' => ($invoiceNumber > \Config::get('sipt.min_invoice_number')) ? $invoiceNumber : \Config::get('sipt.min_invoice_number'),
    //   'invoice_date'   => date('d.m.Y', time()),
    //   'invoice_amount' => \MoneyFormatHelper::number($subscriber->symposium->cost),
    //   'client_number'  => '00000',
    //   'booking_number' => $subscriber->booking_number,
    //   'subscriber'     => $subscriber,
    // ];
    // $this->viewData['invoice'] = $data;

    // // Get payment slip data
    // $paymentSlip = new PaymentSlip($data['client_number'], $data['booking_number'], $data['invoice_number'], $data['invoice_amount']);
    // $this->viewData['payment_slip'] = $paymentSlip->get();
          
    // // Load pdf view
    // $pdf = PDF::loadView('pdf.bill.symposium', $this->viewData);

    // // Set filename
    // $file = 'sipt_rechnung-' . $data['invoice_number'] . '-' . date('d-m-Y-H-i-s', time()) . '.pdf';

    // // Save file to disk
    // $pdf->save(public_path() . '/storage/invoices/' . $file);

    // // Store invoice data
    // $invoice = Invoice::create([
    //   'number' => $data['invoice_number'],
    //   'date'   => $data['invoice_date'],
    //   'amount' => $data['invoice_amount'],
    //   'file'   => $file,
    //   'symposium_subscriber_id' => $subscriber->id,
    //   'symposium_id' => $subscriber->symposium->id
    // ]);
    // $invoice->save();

    Mail::to($subscriber->email)
          ->cc(\Config::get('sipt.email_cc'))
          ->send(
              new SymposiumSubscriptionConfirmation(
                [
                  'subscriber' => $subscriber,
                  'symposium' => $subscriber->symposium,
                  'files' => [
                    //public_path() . '/storage/invoices/' . $file,
                    public_path() . '/storage/downloads/' . 'sipt-lageplan.pdf',
                  ]
                ]
          )
    );
  }
}
