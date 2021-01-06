<?php
namespace App\Exports;
use App\Models\VipAddress;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VipAddressesExport implements FromCollection, WithHeadings
{
  /**
  * @return \Illuminate\Support\Collection
  */
  public function collection()
  {
    $addresses = VipAddress::orderBy('name')->get();
    $data = [];
    foreach($addresses as $a)
    {
      $data[] = [
        'Anrede' => $a->gender,
        'Name' => $a->name,
        'Vorname' => $a->firstname,
        'Titel' => $a->title,
        'Funktion' => $a->role,
        'Firma' => $a->company,
        'Abteilung' => $a->department,
        'Strasse' => $a->street,
        'Nr' => $a->street_no,
        'Adresszusatz' => $a->address_extra,
        'PLZ' => $a->zip,
        'Ort' => $a->city,
        'Land' => $a->country,
        'Telefon' => $a->phone,
        'Mobile' => $a->mobile,
        'E-Mail' => $a->email,
      ];
    }
    return collect($data);
  }

  public function headings(): array
  {
    return [
      'Anrede',
      'Name',
      'Vorname',
      'Titel', 
      'Funktion',
      'Firma',
      'Abteilung',
      'Strasse',
      'Nr',
      'Adresszusatz',
      'PLZ',
      'Ort',
      'Land',
      'Telefon',
      'Mobile',
      'E-Mail',
    ];
  }
}
