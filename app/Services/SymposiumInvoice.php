<?php
namespace App\Services;
use App\Models\Invoice;
use App\Services\PaymentSlip;
use PDF;
use Illuminate\Support\Facades\Storage;

class SymposiumInvoice
{
  /**
   * The invoice date
   */
  protected $date;

  /**
   * The invoice number
   */
  protected $number;

  /** 
   * The invoice amount
   */
  protected $amount;

  /**
   * The invoice amount raw
   */
  protected $amountRaw;

  /**
   * The client
   */
  protected $client;

  /**
   * The client number
   */
  protected $clientNumber;

  /**
   * The booking number
   */
  protected $bookingNumber;

  /**
   * The symposium
   */
  protected $symposium;

  /**
   * The file name
   */
  protected $filename;

  /**
   * The model
   */

  protected $invoice;

  /**
   * The invoice prefix
   */

  protected $prefix = 'sipt_rechnung-';

  public function __construct()
  {
    $this->invoice = new \App\Models\Invoice;
    $this->symposiumSubscriber = new \App\Models\SymposiumSubscriber;
    $this->symposium = new \App\Models\Symposium;
  }

  public function create($data = array())
  {
    $this->date = $data['date'];
    $this->amount = \MoneyFormatHelper::number($data['amount']);
    $this->amountRaw = $data['amount'];
    $this->number = isset($data['number']) && !empty($data['number']) ? $data['number'] : $this->getNumber();
    $this->client = $data['client'];
    $this->clientNumber = $data['client']->number;
    $this->bookingNumber = $data['booking_number'];
    $this->symposium = $data['symposium'];
  }

  /**
   * Write the invoice as pdf to the disk
   * 
   * @return string $filename
   */
  public function write()
  {
    // Set view data for the invoice
    $this->viewData['invoice'] = [
      'invoice_number' => $this->number,
      'invoice_date'   => $this->date,
      'invoice_amount' => $this->amount,
      'client_number'  => $this->clientNumber,
      'client'         => $this->client,
      'booking_number' => $this->bookingNumber,
      'symposium'      => $this->symposium
    ];

    // Set view data for payment slip
    $this->viewData['payment_slip'] = (new PaymentSlip($this->number, $this->clientNumber, $this->amount))->get();

    // Get file name
    $this->filename = $this->getFilename();

    // Load pdf view
    $pdf = PDF::loadView('pdf.bill.symposium', $this->viewData);
    $pdf->save(public_path() . '/storage/invoices/' . $this->filename);
    
    return $this->filename;
  }

  /**
   * Store the invoice to the database
   * 
   * @return Invoice $invoice
   */
  public function store()
  {
    // Store the invoice
    $invoice = $this->invoice->create([
      'number' => $this->number,
      'date'   => $this->date,
      'amount' => $this->amountRaw,
      'file'   => $this->filename,
      'symposium_subscriber_id' => $this->client->id,
      'symposium_id' => $this->symposium->id
    ]);
    $invoice->save();

    // Update 'is_billed' on the symposiumSubscriber table
    $subscriber = $this->symposiumSubscriber->where('id', '=', $this->client->id)
                                            ->where('symposium_id', '=', $this->symposium->id)
                                            ->get()->first();
    $subscriber->is_billed = 1;
    $subscriber->save();

    return $invoice;
  }

  /**
   * Get the invoice number
   */
  private function getNumber()
  {
    return \InvoiceHelper::getNumber();
  }

  /**
   * Get the payment slip data
   */
  private function getPaymentSlip()
  {
    $paymentSlip = new PaymentSlip(
      $this->clientNumber,
      $this->bookingNumber,
      $this->number,
      $this->amount
    );
    return $paymentSlip->get();
  }

  /**
   * Get the file name
   */
  private function getFilename()
  {
    return $this->prefix . $this->number . '-' . date('d-m-Y-H-i-s', time()) . '.pdf';
  }
}