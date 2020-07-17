<?php
namespace App\Services;

class PaymentSlip
{
  protected $clientNumber;
  protected $reservationNumber ;
  protected $invoiceNumber;
  protected $invoiceAmount;

  public function __construct($clientNumber, $reservationNumber, $invoiceNumber, $invoiceAmount)
  {
    $this->clientNumber       = $clientNumber;
    $this->reservationNumber  = $reservationNumber;
    $this->invoiceNumber      = $invoiceNumber;
    $this->invoiceAmount      = $invoiceAmount;
  }

  public function get()
  {
    $data = [
      'client_no'           => $this->clientNumber,
      'reservation_no'      => $this->reservationNumber,
      'invoice_no'          => $this->invoiceNumber,
      'invoice_amount'      => $this->invoiceAmount,
      'invoice_amount_arr'  => $this->getAmountArray(),
      'esr_invoice_no'      => $this->invoiceNumber,
      'esr_reference_str'   => $this->referenceString(),
      'esr_codeline_str'    => $this->referenceCodeLineString(),
    ];

    return $data;
  }

  private function referenceInvoiceNumber()
  {
    $str = '';
    switch(strlen($this->invoiceNumber))
    {
      case 5:
        $str = str_pad(substr($this->invoiceNumber, 0, 1),  5, "0", STR_PAD_LEFT) . ' ' . substr($this->invoiceNumber, 1, strlen($this->invoiceNumber));
      break;

      case 6:
        $str = str_pad(substr($this->invoiceNumber, 0, 2),  5, "0", STR_PAD_LEFT) . ' ' . substr($this->invoiceNumber, 2, strlen($this->invoiceNumber));
      break;

      case 7:
        $str = str_pad(substr($this->invoiceNumber, 0, 3),  5, "0", STR_PAD_LEFT) . ' ' . substr($this->invoiceNumber, 3, strlen($this->invoiceNumber));
      break;
    }

    return $str;
  }

  private function referenceClientString()
  {
    return str_pad($this->clientNumber,  5, "0");
  }

  private function referenceString()
  {
    $esr_customer_id = \Config::get('sipt.esr_customer_id');
    $str = $esr_customer_id . ' 00000 ' . $this->referenceClientString() . ' ' . $this->referenceInvoiceNumber();
    $str = $str . $this->modulo10(str_replace(' ', '', $str));
    return $str;
  }

  /**
   * Get codeline string
   * 
   * @param mixed $amount
   * @param mixed $reference_str
   * @return string
   */
  private function referenceCodeLineString()
  {
    $esr_codeline_prefix = \Config::get('sipt.esr_codeline_prefix');
    $esr_account_int     = \Config::get('sipt.esr_account_int');
    $codeline            = '';
    
    // check for 'rappen'
    $amount_array = $this->getAmountArray();

    // pad amount to a 10 digit number
    $amount_str = str_pad($amount_array[0] . $amount_array[1], 10, "0", STR_PAD_LEFT);

    // calculate check digit with prefix + amount
    $checkDigit = $this->modulo10($esr_codeline_prefix . $amount_str);

    // build codeline
    $codeline  = $esr_codeline_prefix . $amount_str . $checkDigit . '>';
    $codeline .= str_replace(' ', '', $this->referenceString()) . '+';
    $codeline .= ' ' . $esr_account_int;
    $codeline .= '>';
    
    return $codeline;
  }

  /**
   * Split amount into 'Franken' and 'Rappen'
   * 
   * @param mixed $amount
   * @return array
   */
  private function getAmountArray()
  {
    $amount_array = explode('.', $this->invoiceAmount);

    // add zeros if 'rappen' is missing
    if (!isset($amount_array[1]))
    {
      $amount_array[1] = '00';
    }

    return $amount_array;
  }

  /**
   * Calculate modulo10
   * 
   * @param integer $number
   * @return integer
   */
  private function modulo10($number)
  {
    $table = array(0,9,4,6,8,2,7,1,3,5);
    $next = 0;
    for ($i=0; $i<strlen($number); $i++)
    {
      $next = $table[($next + substr($number, $i, 1)) % 10];
    }
    return (10 - $next) % 10;
  }
}