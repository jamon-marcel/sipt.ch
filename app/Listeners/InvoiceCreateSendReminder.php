<?php
namespace App\Listeners;
use App\Models\Invoice;
use App\Models\Student;
use App\Models\SymposiumSubscriber;
use App\Mail\InvoiceSendReminder;
use PDF;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Events\InvoiceReminder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class InvoiceCreateSendReminder
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct(Student $student, Invoice $invoice, SymposiumSubscriber $subscriber)
  {
    $this->student = $student;
    $this->invoice = $invoice;
    $this->subscriber = $subscriber;
  }

  /**
   * Handle the event.
   *
   * @param InvoiceReminder $event
   * @return void
   */
  public function handle(InvoiceReminder $event)
  {
    $invoice    = $event->invoice;
    $noticeType = $event->noticeType;

    if ($invoice->student_id)
    {
      $recipient = $this->student->with('user')->find($invoice->student_id);
      $recipient_email = $recipient->user->email;
    }
    else if ($invoice->symposium_subscriber_id)
    {
      $recipient = $this->subscriber->find($invoice->symposium_subscriber_id);
      $recipient_email = $recipient->email;
    }

    // Update invoice
    $invoice->date_notice = date('d.m.Y', time());
    $invoice->user_id = auth()->user()->id;
    $invoice->state = $noticeType;
    $invoice->save();

    // Send reminder
    $this->notify($invoice, $recipient, $recipient_email, $noticeType);
  }

  /**
   * Notify the user
   * 
   * @param $invoice
   * @param $recipient
   * @param $noticeType
   * @return void
   */
  public function notify($invoice, $recipient, $recipient_email, $noticeType)
  {
    Mail::to($recipient_email)
          ->bcc(\Config::get('sipt.email_copy'))
          ->send(
              new InvoiceSendReminder(
                [
                  'invoice'    => $invoice,
                  'recipient'  => $recipient,
                  'noticeType' => $noticeType,
                  'pdf'        => public_path() . '/storage/invoices/' . $invoice->file,
                ]
          )
    );
  }
}
