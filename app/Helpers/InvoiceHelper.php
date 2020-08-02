<?php
namespace App\Helpers;
use App\Models\Invoice;

class InvoiceHelper
{
  public static function getNumber()
  {
    $max_number = Invoice::withTrashed()->max('number') + 1;
    $invoice_number = ($max_number > \Config::get('sipt.min_invoice_number')) ? $max_number : \Config::get('sipt.min_invoice_number');
    return str_pad($invoice_number, 6, "0", STR_PAD_LEFT);
  }
}