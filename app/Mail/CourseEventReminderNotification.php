<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CourseEventReminderNotification extends Mailable
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
    $mail = $this->subject('Kurserinnerung Modul «' . $this->data['courseEvent']->course->title . '»')
                 ->with(
                   [
                     'tutor' => $this->data['tutor'],
                     'courseEvent' => $this->data['courseEvent'],
                     'hasMap' => $this->data['hasMap']
                   ]
                 )
                 ->markdown('mails.course_event.reminder');

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
