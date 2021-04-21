<?php
namespace App\Exports;
use App\Models\Tutor;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TutorAddressesExport implements FromCollection, WithHeadings
{
  /**
  * @return \Illuminate\Support\Collection
  */
  public function collection()
  {
    $tutors = Tutor::with('user')->orderBy('name')->get();
    $data = [];
    foreach($tutors as $t)
    {
      $data[] = [
        'Name' => $t->name,
        'Vorname' => $t->firstname,
        'Titel' => $t->title,
        'Strasse' => $t->street,
        'Nr' => $t->street_no,
        'PLZ' => $t->zip,
        'Ort' => $t->city,
        'Land' => $t->country,
        'Telefon' => $t->phone,
        'Mobile' => $t->mobile,
        'E-Mail' => $t->user->email,
        'Newsletter' => $t->user->is_newsletter_subscriber
      ];
    }
    return collect($data);
  }

  public function headings(): array
  {
    return [
      'Name',
      'Vorname',
      'Titel', 
      'Strasse',
      'Nr',
      'PLZ',
      'Ort',
      'Land',
      'Telefon',
      'Mobile',
      'E-Mail',
      'Newsletter'
    ];
  }
}
