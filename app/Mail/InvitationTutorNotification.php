<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationTutorNotification extends Mailable
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
    $mail = $this->subject('Neue Webseite')
                 ->with(
                   [
                     'tutor'    => $this->data['tutor'],
                     'email'    => $this->data['email'],
                     'password' => $this->data['password'],
                   ]
                 )
                 ->markdown('mails.invitation.tutor');
    return $mail;
  }
}
