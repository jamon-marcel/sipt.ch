<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\Invoice;
use App\Events\InvoiceReminder;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
  public function __construct(Invoice $invoice)
  {
    $this->invoice = $invoice;
  }

  /**
   * Get all invoices
   *
   * @return \Illuminate\Http\Response
   */
  public function get()
  {
    $invoices = $this->invoice->with('event.course', 'student', 'symposiumSubscriber', 'symposium')
                              ->orderBy('number', 'DESC')
                              ->get();
    return new DataCollection($invoices);
  }

  /**
   * Get history by given invoice
   *
   * @param Invoice $invoice
   * @return \Illuminate\Http\Response
   */
  public function getHistory(Invoice $invoice)
  {
    $invoice = $this->invoice->with('event.course', 'student', 'symposiumSubscriber', 'symposium', 'replacement')
                             ->where('replaced_by', '=', $invoice->id)
                             ->withTrashed()
                             ->get()
                             ->first();
    return response()->json($invoice);
  }

  /**
   * Get a single invoice for a given invoice
   * 
   * @param Invoice $invoice
   * @return \Illuminate\Http\Response
   */
  public function find(Invoice $invoice)
  {
    $invoice = $this->invoice->findOrFail($invoice->id);
    return response()->json($invoice);
  }

  /**
   * Update the state of a given invoice
   *
   * @param Invoice $invoice
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function state(Invoice $invoice, Request $request)
  {
    $invoice->update($request->all());
    $invoice->is_paid = $invoice->is_paid == 0 ? 1 : 0;
    $invoice->save();
    return response()->json($invoice->is_paid); 
  }

  /**
   * Send invoice notice by given invoice and type
   * 
   * @param Invoice $invoice
   * @param String $noticeType
   * @return \Illuminate\Http\Response
   */

  public function notice(Invoice $invoice, $noticeType = NULL)
  {
    event(new InvoiceReminder($invoice, $noticeType));
    return response()->json(true); 
  }
}
