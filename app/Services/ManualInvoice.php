<?php
namespace App\Services;
use App\Models\Invoice;
use App\Services\PaymentSlip;
use PDF;
use Illuminate\Support\Facades\Storage;

class ManualInvoice
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
   * The client type
   */
  protected $clientType;

  /**
   * The booking number
   */
  protected $bookingNumber;

  /**
   * The description
   */
  protected $description;

  /**
   * The remarks
   */
  protected $remarks;

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
  }

  public function create($data = array())
  {
    $this->date = $data['date'];
    $this->amount = \MoneyFormatHelper::number($data['amount']);
    $this->amountRaw = $data['amount'];
    $this->number = isset($data['number']) && !empty($data['number']) ? $data['number'] : $this->getNumber();
    $this->bookingNumber = isset($data['booking_number']) && !empty($data['booking_number']) ? $data['booking_number'] : NULL;
    $this->description = isset($data['description']) && !empty($data['description']) ? $data['description'] : NULL;
    $this->remarks = isset($data['remarks']) && !empty($data['remarks']) ? $data['remarks'] : NULL;
    $this->clientType = $data['client_type'];
    $this->client = $data['client'];
    
    $this->clientNumber = NULL;
    if ($this->clientType == 'student')
    {
      $this->clientNumber = $data['client']->number;
    }
    
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
      'description'    => $this->description,
      'client_number'  => $this->clientNumber,
      'client_type'    => $this->clientType,
      'client'         => $this->client,
      'booking_number' => $this->bookingNumber,
      'remarks'        => $this->remarks,
      'description'    => $this->description,
    ];

    // Set view data for payment slip
    $this->viewData['payment_slip'] = $this->getPaymentSlip();

    // Get file name
    $this->filename = $this->getFilename();

    // Load pdf view
    $pdf = PDF::loadView('pdf.bill.manual', $this->viewData);
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
      'student_id' => $this->clientType == 'student' ? $this->client->id : NULL,
      'tutor_id' => $this->clientType == 'tutor' ? $this->client->id : NULL,
      'course_event_id' => NULL,
      'recipient' => $this->clientType == 'other' ? $this->client : NULL,
      'remarks' => $this->remarks,
      'description' => $this->description,
    ]);
    $invoice->save();
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
      NULL,
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