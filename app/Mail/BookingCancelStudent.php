<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingCancelStudent extends Mailable
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
    $mail = $this->subject('Annulation Modul «' . $this->data['courseEvent']->course->title . '»')
                 ->with(
                   [
                     'student' => $this->data['student'],
                     'courseEvent' => $this->data['courseEvent'],
                   ]
                 )
                 ->markdown('mails.booking.confirmation-cancel');
    return $mail;
  }
}
