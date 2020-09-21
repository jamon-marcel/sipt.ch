<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Message extends Mailable
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
    $mail = $this->subject($this->data['message']->subject . ' – ' . $this->data['courseEvent']->course->title)
                  ->with(
                    [
                      'recipient' => $this->data['recipient'],
                      'message' => $this->data['message'],
                      'courseEvent' => $this->data['courseEvent'],
                    ]
                  )
                 ->markdown('mails.course_event.message');
    return $mail;
  }
}
