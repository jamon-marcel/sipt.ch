<?php
namespace App\Listeners;
use App\Events\SymposiumCancelled;
use App\Models\SymposiumSubscriber;
use App\Models\Invoice;
use App\Services\PaymentSlip;
use App\Mail\SymposiumCancelBillingNotification;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SymposiumCancelSubscription
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct(SymposiumSubscriber $symposiumSubscriber, Invoice $invoice)
  {
    $this->symposiumSubscriber = $symposiumSubscriber;
    $this->invoice = $invoice;
  }

  /**
   * Handle the event.
   *
   * @param  SymposiumCancelled $event
   * @return void
   */
  public function handle(SymposiumCancelled $event)
  {
    $symposiumSubscriber = $event->symposiumSubscriber;
    $symposium           = $event->symposium;
    $penalty             = $event->penalty;

    // Create invoice number
    $invoiceNumber  = \InvoiceHelper::getNumber();
    
    // Calculate amount
    if ($penalty == 'partial')
    {
      $amount = 80;
    }
    else if ($penalty == 'full')
    {
      $amount = $symposiumSubscriber->cost;
    }
    
    // Set data
    $data = [
      'invoice_number'      => $invoiceNumber,
      'invoice_date'        => date('d.m.Y', time()),
      'invoice_amount'      => \MoneyFormatHelper::number($amount),
      'client_number'       => $symposiumSubscriber->number,
      'booking_number'      => $symposiumSubscriber->booking_number,
      'symposiumSubscriber' => $symposiumSubscriber,
      'symposium'           => $symposium
    ];
    $this->viewData['invoice'] = $data;

    // Get payment slip data
    $paymentSlip = new PaymentSlip($data['client_number'], $data['booking_number'], $data['invoice_number'], $data['invoice_amount']);
    $this->viewData['payment_slip'] =  $paymentSlip->get();
          
    // Load pdf view
    $pdf = PDF::loadView('pdf.bill.symposium-cancel', $this->viewData);

    // Set filename
    $file = 'sipt_rechnung-' . $data['invoice_number'] . '-' . date('d-m-Y-H-i-s', time()) . '.pdf';

    // Save file to disk
    $pdf->save(public_path() . '/storage/invoices/' . $file);

    // Store invoice data
    $invoice = Invoice::create([
      'number' => $data['invoice_number'],
      'date'   => $data['invoice_date'],
      'amount' => $data['invoice_amount'],
      'file'   => $file,
      'symposium_subscriber_id' => $symposiumSubscriber->id,
      'symposium_id' => $symposium->id
    ]);
    $invoice->save();
    
    // Check for existing bills
    if ($symposiumSubscriber->is_billed == 1)
    {
      $old_invoices = $this->invoice->where('symposium_subscriber_id', '=', $symposiumSubscriber->id)->where('symposium_id', '=', $symposium->id)->get();
      foreach($old_invoices as $oi)
      {
        if ($oi->id != $invoice->id)
        {
          $oi->replaced_by = $invoice->id;
          $oi->save();
          $oi->delete();
        }
      }
      $invoice->is_replacement = 1;
      $invoice->save();
    }
    
    // Send mail to student
    Mail::to($symposiumSubscriber->email)
          ->bcc(\Config::get('sipt.email_copy'))
          ->send(
              new SymposiumCancelBillingNotification(
                [
                  'symposiumSubscriber' => $symposiumSubscriber,
                  'symposium'           => $symposium,
                  'penalty'             => $penalty,
                  'invoice_number'      => $data['invoice_number'],
                  'invoice_amount'      => $data['invoice_amount'],
                  'pdf'                 => public_path() . '/storage/invoices/' . $file
                ]
          )
    );
  }
}
