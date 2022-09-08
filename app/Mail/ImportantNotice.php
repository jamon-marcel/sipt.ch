<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ImportantNotice extends Mailable
{
  use Queueable, SerializesModels;

  protected $data;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct()
  {
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    $mail = $this->subject('Neues Kursangebot "So vertiefen Sie Ihr psychodynamisches Fallverständnis"')->markdown('mails.important-notice.index');
    //$mail->attach(public_path() . '/storage/downloads/' . 'Flyer-Fachtagung-2022.pdf', ['mime' => 'application/pdf']);
    return $mail;
  }
}
