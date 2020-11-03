<?php
namespace App\Exports;
use App\Models\SymposiumSubscriber;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SymposiumSubscribersExport implements FromCollection, WithHeadingRow
{
  /**
  * @return \Illuminate\Support\Collection
  */
  public function collection()
  {
    $subscribers = SymposiumSubscriber::with('symposium', 'invoice')->orderBy('created_at', 'DESC')->where('is_cancelled', '=', 0)->get();
    $data = [];
    foreach($subscribers as $s)
    {
      $paid = $s->invoice && $s->invoice->is_paid ? 'ja' : 'nein';
      $data[] = [
        'Kunden-Nr.' => $s->number,
        'Name' => $s->fullName,
        'Ort' => $s->city,
        'E-Mail' => $s->email,
        'Titel' => $s->title,
        'Buchungs-Nr.' => $s->booking_number,
        'Bezahlt' => $paid,
        'Betrag' => \MoneyFormatHelper::number($s->cost),
        'Registrations-Datum' => date('d.m.Y', strtotime($s->created_at))
      ];
    }
    return collect($data);
  }
}
