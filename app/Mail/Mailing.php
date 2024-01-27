<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Mailing extends Mailable
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
    $mail = $this->subject($this->data['mailing']['subject'])
              ->with([
                'salutation' => $this->data['mailing']['salutation'],
                'body' => $this->data['mailing']['body'],
                'greetings' => $this->data['mailing']['greetings'],
                'subscriber' => $this->data['subscriber'] ?? null,
              ])
              ->markdown('mails.mailinglist.templates.mailing');
    
    if (isset($this->data['mailing']['attachment_array']))
    {
      foreach($this->data['mailing']['attachment_array'] as $file)
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
