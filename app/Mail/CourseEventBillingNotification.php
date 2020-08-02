<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CourseEventBillingNotification extends Mailable
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
    $mail = $this->subject('Rechnung ' . $this->data['invoice_number'])
                 ->with(
                   [
                     'student' => $this->data['student'],
                     'courseEvent' => $this->data['courseEvent'],
                     'invoiceNumber' => $this->data['invoice_number'],
                     'invoiceAmount' => $this->data['invoice_amount']
                   ]
                 )
                 ->markdown('mails.course_event.bill');
    
    if ($this->data['attachment'])
    {
      $mail->attach($this->data['attachment'], ['mime' => 'application/pdf']);
    }
    return $mail;
  }
}
