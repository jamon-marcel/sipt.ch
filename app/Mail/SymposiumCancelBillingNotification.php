<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SymposiumCancelBillingNotification extends Mailable
{
  use Queueable, SerializesModels;

  protected $data;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($data)
  {
    $this->data = $data;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    $mail = $this->subject('Annullation Fachtagung')
                 ->with(
                   [
                     'symposiumSubscriber' => $this->data['symposiumSubscriber'],
                     'symposium' => $this->data['symposium'],
                     'penalty' => $this->data['penalty'],
                     'invoiceNumber' => $this->data['invoice_number'],
                     'invoiceAmount' => $this->data['invoice_amount']
                   ]
                 )
                 ->markdown('mails.symposium.cancel');
    
    if ($this->data['pdf'])
    {
      $mail->attach($this->data['pdf'], ['mime' => 'application/pdf']);
    }
    return $mail;
  }
}
