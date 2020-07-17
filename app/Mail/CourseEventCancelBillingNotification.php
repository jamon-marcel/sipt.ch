<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CourseEventCancelBillingNotification extends Mailable
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
    $mail = $this->subject('Annullation Modul «' . $this->data['courseEvent']->course->title . '»')
                 ->with(
                   [
                     'student' => $this->data['student'],
                     'courseEvent' => $this->data['courseEvent'],
                     'penalty' => $this->data['penalty'],
                     'invoiceNumber' => $this->data['invoice_number'],
                     'invoiceAmount' => $this->data['invoice_amount']
                   ]
                 )
                 ->markdown('mails.course_event.bill-cancel');
    
    if ($this->data['pdf'])
    {
      $mail->attach($this->data['pdf'], ['mime' => 'application/pdf']);
    }
    return $mail;
  }
}
