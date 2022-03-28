<?php
namespace App\Exports;
use App\Models\Student;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentAddressesExport implements FromCollection, WithHeadings
{
  /**
  * @return \Illuminate\Support\Collection
  */
  public function collection()
  {
    $students = Student::orderBy('name')->get();
    $data = [];
    foreach($students as $s)
    {
      // Get user
      $user = User::find($s->user->id);
      $active = $s->is_active ? 'ja' : 'nein';
      $data[] = [
        'Name' => $s->name,
        'Vorname' => $s->firstname,
        'Titel' => $s->title,
        'Ausbildung' => $s->qualifications,
        'Strasse' => $s->street,
        'Nr' => $s->street_no,
        'PLZ' => $s->zip,
        'Ort' => $s->city,
        'Land' => $s->country,
        'Telefon' => $s->phone,
        'Telefon G.' => $s->phone_business,
        'Mobile' => $s->mobile,
        'E-Mail' => $user ? $user->email : 'noemail',
        'Aktiv' => $active,
        'Newsletter' => $user ? $user->is_newsletter_subscriber : '0'
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
      'Ausbildung',
      'Strasse',
      'Nr',
      'PLZ',
      'Ort',
      'Land',
      'Telefon',
      'Telefon G.',
      'Mobile',
      'E-Mail',
      'Aktiv',
      'Newsletter'
    ];
  }
}
