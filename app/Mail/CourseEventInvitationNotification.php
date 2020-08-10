<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CourseEventInvitationNotification extends Mailable
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
    $mail = $this->subject('Kurseinladung Modul «' . $this->data['courseEvent']->course->title . '»')
                 ->with(
                   [
                     'student' => $this->data['student'],
                     'courseEvent' => $this->data['courseEvent'],
                     'hasMap' => $this->data['hasMap']
                   ]
                 )
                 ->markdown('mails.course_event.invitation');

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
