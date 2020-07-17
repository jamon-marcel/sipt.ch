<?php
namespace App\Events;
use App\Models\Invoice;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceReminder
{
  use Dispatchable, SerializesModels;

  public $invoice;
  public $type;

  /**
   * Create a new event instance.
   *
   * @param Invoice $invoice
   * @param String $noticeType
   * @return void
   */
  public function __construct(Invoice $invoice, $noticeType)
  {
    $this->invoice = $invoice;
    $this->noticeType = $noticeType;
  }
}
