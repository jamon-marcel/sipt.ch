<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationStudentNotification extends Mailable
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
                     'student'  => $this->data['student'],
                     'email'    => $this->data['email'],
                     'password' => $this->data['password'],
                   ]
                 )
                 ->markdown('mails.invitation.student');
    return $mail;
  }
}
