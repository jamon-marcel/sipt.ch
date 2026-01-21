<?php
namespace App\Services;
use App\Models\Invoice;
use App\Models\AnniversaryRegistration;
use App\Services\PaymentSlip;
use PDF;

class AnniversaryInvoice
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
   * The registration
   */
  protected $registration;

  /**
   * The booking number
   */
  protected $bookingNumber;

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

  /**
   * View data for PDF
   */
  protected $viewData = [];

  public function __construct()
  {
    $this->invoice = new Invoice;
  }

  public function create($data = array())
  {
    $this->date = $data['date'];
    $this->amount = \MoneyFormatHelper::number($data['amount']);
    $this->amountRaw = $data['amount'];
    $this->number = isset($data['number']) && !empty($data['number']) ? $data['number'] : $this->getNumber();
    $this->registration = $data['registration'];
    $this->bookingNumber = $data['registration']->booking_number;
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
      'booking_number' => $this->bookingNumber,
      'registration'   => $this->registration,
    ];

    // Set view data for payment slip
    $this->viewData['payment_slip'] = (new PaymentSlip($this->number, $this->bookingNumber, $this->amount))->get();

    // Get file name
    $this->filename = $this->getFilename();

    // Load pdf view
    $pdf = PDF::loadView('pdf.bill.anniversary', $this->viewData);
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
      'anniversary_registration_id' => $this->registration->id,
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
   * Get the file name
   */
  private function getFilename()
  {
    return $this->prefix . $this->number . '-' . date('d-m-Y-H-i-s', time()) . '.pdf';
  }

  /**
   * Get the full path to the invoice file
   */
  public function getFilePath()
  {
    return public_path() . '/storage/invoices/' . $this->filename;
  }
}
