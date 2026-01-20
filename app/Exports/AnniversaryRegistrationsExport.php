<?php
namespace App\Exports;
use App\Models\AnniversaryRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AnniversaryRegistrationsExport implements FromCollection, WithHeadingRow
{
  /**
  * @return \Illuminate\Support\Collection
  */
  public function collection()
  {
    $registrations = AnniversaryRegistration::with('invoice')->orderBy('created_at', 'DESC')->where('is_cancelled', '=', 0)->get();
    $data = [];
    foreach($registrations as $r)
    {
      $paid = $r->invoice && $r->invoice->is_paid ? 'ja' : 'nein';
      $ticketLabels = [
        'both_days' => 'Beide Tage',
        'friday_only' => 'Nur Freitag',
        'saturday_only' => 'Nur Samstag',
      ];
      $data[] = [
        'Name' => $r->fullName,
        'Strasse' => $r->street . ' ' . $r->street_number,
        'PLZ' => $r->zip,
        'Ort' => $r->city,
        'E-Mail' => $r->email,
        'Telefon' => $r->phone,
        'Titel' => $r->title,
        'Ticket' => $ticketLabels[$r->ticket_type] ?? $r->ticket_type,
        'Apéro Freitag' => $r->apero_friday ? 'ja' : 'nein',
        'Mittagessen Samstag' => $r->lunch_saturday ? 'ja' : 'nein',
        'Frühbucher' => $r->is_early_bird ? 'ja' : 'nein',
        'Buchungs-Nr.' => $r->booking_number,
        'Bezahlt' => $paid,
        'Betrag' => \MoneyFormatHelper::number($r->cost),
        'Registrations-Datum' => date('d.m.Y', strtotime($r->created_at))
      ];
    }
    return collect($data);
  }
}
