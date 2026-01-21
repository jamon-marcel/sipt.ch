<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AnniversaryRegistrationConfirmation extends Mailable
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
    $mail = $this->subject('Bestätigung Anmeldung – 20 Jahre SIPT Fachtagung')
                 ->with(['registration' => $this->data['registration']])
                 ->markdown('mails.anniversary.confirmation');

    if (isset($this->data['attachment']) && $this->data['attachment'])
    {
      $mail->attach($this->data['attachment'], ['mime' => 'application/pdf']);
    }

    return $mail;
  }
}
