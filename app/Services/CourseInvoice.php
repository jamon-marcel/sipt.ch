<?php
namespace App\Services;
use App\Models\Invoice;
use App\Services\PaymentSlip;
use PDF;
use Illuminate\Support\Facades\Storage;

class CourseInvoice
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
   * The course event
   */
  protected $courseEvent;

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
    $this->courseEventStudent = new \App\Models\CourseEventStudent;
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
    $this->courseEvent = $data['course_event'];
    $this->alt_address = isset($data['alt_address']) ? $data['alt_address'] : null;
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
      'courseEvent'    => $this->courseEvent,
      'alt_address'    => $this->alt_address
    ];

    // Set view data for payment slip
    $this->viewData['payment_slip'] = $this->getPaymentSlip();

    // Get file name
    $this->filename = $this->getFilename();

    // Load pdf view
    $pdf = PDF::loadView('pdf.bill.course', $this->viewData);
    $pdf->save(public_path() . '/storage/invoices/' . $this->filename);
    
    return $this->filename;
  }

  /**
   * Store the invoice
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
      'student_id' => $this->client->id,
      'course_event_id' => $this->courseEvent->id
    ]);
    $invoice->save();

    // Update 'is_billed' on the pivot table
    $pivot = $this->courseEventStudent->where('student_id', '=', $this->client->id)
                                      ->where('course_event_id', '=', $this->courseEvent->id)
                                      ->get()->first();
    $pivot->is_billed = 1;
    $pivot->save();

    return $invoice;
  }

  /**
   * Update an invoice
   * 
   * @param String $invoiceId
   * @return Invoice $invoice
   */
  public function update($invoiceId)
  {
    // Get the invoice
    $invoice = $this->invoice->findOrFail($invoiceId);
    $invoice->date = $this->date;
    $invoice->amount = $this->amount;
    $invoice->file = $this->filename;
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