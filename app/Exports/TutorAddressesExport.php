<?php
namespace App\Exports;
use App\Models\Tutor;
use App\Models\User;
use App\Models\MailinglistSubscriber;
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
      $email = $t->user->email ? $t->user->email : 'noemail';

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
        'E-Mail' => $email,
        'Newsletter' => MailinglistSubscriber::where('email', $email)->where('mailinglist_id', env('MAILINGLIST_NEWSLETTER'))->first() ? '1' : '0',
        'Aufbautipp' => $t->user->is_newsletter_subscriber ? '1' : '0'
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
      'Newsletter',
      'Aufbautipp'
    ];
  }
}
