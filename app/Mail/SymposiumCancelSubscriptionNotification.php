<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SymposiumCancelSubscriptionNotification extends Mailable
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
                   ]
                 )
                 ->markdown('mails.symposium.cancel');
    return $mail;
  }
}
