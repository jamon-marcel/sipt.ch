<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceSendReminder extends Mailable
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
    $noticeType = \Config::get('sipt.notice_types.'. $this->data['noticeType']);
    $mail = $this->subject($noticeType . ' – Rechnung ' . $this->data['invoice']->number)
                 ->with(
                   [
                     'recipient' => $this->data['recipient'],
                     'invoice' => $this->data['invoice']
                   ]
                 )
                 ->markdown('mails.reminder.reminder_' . $this->data['noticeType']);
    
    if ($this->data['pdf'])
    {
      $mail->attach($this->data['pdf'], ['mime' => 'application/pdf']);
    }
    return $mail;
  }
}
