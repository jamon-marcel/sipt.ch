<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OnboardingStudentNotification extends Mailable
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
    $mail = $this->subject('Neue Webseite psychotraumatologie-sipt.ch')
                 ->with(
                   [
                     'student'  => $this->data['student'],
                     'email'    => $this->data['email'],
                     'password' => $this->data['password'],
                   ]
                 )
                 ->markdown('mails.onboarding.student');
    
    if ($this->data['attachments'])
    {
      foreach($this->data['attachments'] as $file)
      {
        if ($file)
        {
          $mail->attach($file, ['mime' => 'application/pdf']);
        }
      }
    }
    
    return $mail;
  }
}
