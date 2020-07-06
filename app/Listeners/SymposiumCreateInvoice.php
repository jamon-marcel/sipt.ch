<?php
namespace App\Listeners;
use App\Events\SymposiumConfirmSubscription;
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

    // Generate invoice number
    $invoice_number = 'sipt-rechnung-fachtagung-' . $subscriber->id; 

    $subscriber->invoice_number = $invoice_number;
    $subscriber->save();

    // Create invoice
    $this->viewData['subscriber'] = $subscriber;
    $pdf = PDF::loadView('pdf.symposium.invoice', $this->viewData);

    // Set path & filename
    $path = public_path() . '/storage/invoices/';
    $file = $invoice_number . '.pdf';

    // Store invoice
    $pdf->save($path . '/' . $file);
  }




/*

  // Rechnungs Nr.: 604979
  // ezs_bankingCustomerIdentification = 0100000


//create bottom line string
			$bottomLineString = '';
		
			//EZS with amount or not?
      $amountParts = explode(".", $this->ezs_amount);

      $bottomLineString .= "01";
      $bottomLineString .= str_pad($amountParts[0], 8 ,'0', STR_PAD_LEFT);
      $bottomLineString .= str_pad($amountParts[1], 2 ,'0', STR_PAD_RIGHT);
      $bottomLineString .= $this->modulo10($bottomLineString);
      $bottomLineString .= ">";
			
			
			//add reference number
			$bottomLineString .= $this->createCompleteReferenceNumber();
			$bottomLineString .= "+ ";
			
			//add banking account
			$bankingAccountParts = explode("-", $this->ezs_bankingAccount);
			$bottomLineString .= str_pad($bankingAccountParts[0], 2 ,'0', STR_PAD_LEFT);
			$bottomLineString .= str_pad($bankingAccountParts[1], 6 ,'0', STR_PAD_LEFT);
			$bottomLineString .= str_pad($bankingAccountParts[2], 1 ,'0', STR_PAD_LEFT);
			$bottomLineString .= ">";


			//Set bottom line
			$this->pdf->AddFont('OCRB10');
			$this->pdf->SetFont('OCRB10','',10);
			$this->pdf->SetXY($this->marginLeft+67, $this->marginTop+85); 
      $this->pdf->Cell(140,4,$bottomLineString, 0, 0, "R");
      
*/

    // private function createCompleteReferenceNumber()
    // {
    
    //   //get reference number and fill with zeros
    //   $completeReferenceNumber = str_pad($this->ezs_referenceNumber, (26 - strlen($this->ezs_bankingCustomerIdentification)) ,'0', STR_PAD_LEFT);
    
    //   //add customer identification code
    //   $completeReferenceNumber = $this->ezs_bankingCustomerIdentification.$completeReferenceNumber;
      
    //   //add check digit
    //   $completeReferenceNumber .= $this->modulo10($completeReferenceNumber);
      
    //   //return
    //   return $completeReferenceNumber;
    // }
  
    // private function modulo10($number)
    // {
    //   $table = array(0,9,4,6,8,2,7,1,3,5);
    //   $next = 0;
    //   for ($i=0; $i<strlen($number); $i++) {
    //     $next = $table[($next + substr($number, $i, 1)) % 10];
    //   }//for		
    //   return (10 - $next) % 10;
    // }

}
