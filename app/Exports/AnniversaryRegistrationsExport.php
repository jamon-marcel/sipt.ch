<?php
namespace App\Exports;
use App\Models\AnniversaryRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AnniversaryRegistrationsExport implements FromCollection, WithHeadings
{
  /**
  * @return array
  */
  public function headings(): array
  {
    return [
      'Name',
      'Strasse',
      'PLZ',
      'Ort',
      'E-Mail',
      'Telefon',
      'Titel',
      'Ticket',
      'Apéro Freitag',
      'Mittagessen Samstag',
      'Frühbucher',
      'Buchungs-Nr.',
      'Betrag',
      'Registrations-Datum'
    ];
  }

  /**
  * @return \Illuminate\Support\Collection
  */
  public function collection()
  {
    $registrations = AnniversaryRegistration::orderBy('created_at', 'DESC')->where('is_cancelled', '=', 0)->get();
    $data = [];
    foreach($registrations as $r)
    {
      $ticketLabels = [
        'both_days' => 'Beide Tage',
        'friday_only' => 'Nur Freitag',
        'saturday_only' => 'Nur Samstag',
      ];
      $data[] = [
        $r->fullName,
        $r->street . ' ' . $r->street_no,
        $r->zip,
        $r->city,
        $r->email,
        $r->phone,
        $r->title,
        $ticketLabels[$r->ticket_type] ?? $r->ticket_type,
        $r->apero_friday ? 'ja' : 'nein',
        $r->lunch_saturday ? 'ja' : 'nein',
        $r->is_early_bird ? 'ja' : 'nein',
        $r->booking_number,
        \MoneyFormatHelper::number($r->cost),
        date('d.m.Y', strtotime($r->created_at))
      ];
    }
    return collect($data);
  }
}
