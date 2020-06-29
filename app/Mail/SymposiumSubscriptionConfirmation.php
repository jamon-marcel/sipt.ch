<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SymposiumSubscriptionConfirmation extends Mailable
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
    $mail = $this->subject('Bestätigung Anmeldung Fachtagung')
                 ->with(['subscriber' => $this->data['subscriber']])
                 ->markdown('mails.symposium.confirmation');

    foreach($this->data['files'] as $file)
    {
      $mail->attach($file, ['mime' => 'application/pdf']);
    }

    return $mail;
  }
}
