<?php
namespace App\Services;
use Sprain\SwissQrBill as QrBill;

class PaymentSlip
{
  protected $invoiceNumber;
  protected $clientNumber; 
  protected $amount;

  public function __construct($invoiceNumber, $clientNumber, $amount)
  {
    $this->invoiceNumber = $invoiceNumber;
    $this->clientNumber = $clientNumber;
    $this->amount = $amount;
  }

  public function get()
  {
    return [
      'reference_number' => $this->getReferenceNumberString(),
      'qr_code' => $this->getQrCode(),
    ];
  }

  /**
   * Get reference number as padded string
   * 
   * @return String $referenceNumber
   */
  private function getReferenceNumberString()
  {
    $esr_customer_id = config('sipt.esr_customer_id');
    $str = $esr_customer_id . ' 77170 ' . $this->getClientNumberString() . ' ' . $this->getInvoiceNumberString();
    $str = $str . $this->getModulo10(str_replace(' ', '', $str));
    return $str;
  }

  /**
   * Get QR code
   */
  private function getQrCode()
  {
    // Create a new instance of QrBill, containing default headers with fixed values
    $qrBill = QrBill\QrBill::create();

    // Add creditor information
    // Who will receive the payment and to which bank account?
    $qrBill->setCreditor(
      QrBill\DataGroup\Element\CombinedAddress::create(
        config('invoice.beneficiary_name'),
        config('invoice.beneficiary_street'),
        config('invoice.beneficiary_city'),
        config('invoice.beneficiary_country'),
      )
    );

    $qrBill->setCreditorInformation(
      QrBill\DataGroup\Element\CreditorInformation::create(
        str_replace(' ', '', config('invoice.qr_iban'))
      )
    );

    // Add payment amount information
    // The currency must be defined.
    $qrBill->setPaymentAmountInformation(
      QrBill\DataGroup\Element\PaymentAmountInformation::create(
        config('invoice.currency'),
        $this->amount
      )
    );

    // Add payment reference
    // Explicitly define that no reference number will be used by setting TYPE_NON.
    // $qrBill->setPaymentReference(
    //   QrBill\DataGroup\Element\PaymentReference::create(
    //     QrBill\DataGroup\Element\PaymentReference::TYPE_NON
    //   )
    // );


    // Add payment reference
    // This is what you will need to identify incoming payments.
    $referenceNumber = QrBill\Reference\QrPaymentReferenceGenerator::generate(
      config('sipt.esr_customer_id'),  // You receive this number from your bank (BESR-ID). Unless your bank is PostFinance, in that case use NULL.
      $this->invoiceNumber // A number to match the payment with your internal data, e.g. an invoice number
    );

    $qrBill->setPaymentReference(
      QrBill\DataGroup\Element\PaymentReference::create(
          QrBill\DataGroup\Element\PaymentReference::TYPE_QR,
          $referenceNumber
      ));

    // Optionally, add some human-readable information about what the bill is for.
    $qrBill->setAdditionalInformation(
      QrBill\DataGroup\Element\AdditionalInformation::create(
        'Rechnung ' . $this->invoiceNumber
      )
    );

    
    // Return Data URI
    return $qrBill->getQrCode()->writeDataUri();
  }


  /**
   * Get invoice number as padded string
   * 
   * @return String $invoiceNumber
   */

  private function getInvoiceNumberString()
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

  /**
   * Get client number as padded string
   * 
   * @return String $clientNumber
   */

  private function getClientNumberString()
  {
    return str_pad($this->clientNumber,  5, "0");
  }

  /**
   * Calculate modulo10
   * 
   * @param integer $number
   * @return integer
   */

  private function getModulo10($number)
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