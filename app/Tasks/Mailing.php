<?php
namespace App\Tasks;

class Mailing
{
  public function __invoke()
  {
    // Mailinglist "NEWSLETTER"
    $subscribers_newsletter = \App\Models\MailinglistSubscriber::active()->where('mailinglist_id', env('MAILINGLIST_NEWSLETTER'))->get();
    $subscribers_newsletter = collect($subscribers_newsletter)->splice(0, 3);
    foreach($subscribers_newsletter->all() as $s)
    {
      try {
        \Mail::to($s->email)
          ->send(
            new \App\Mail\Mailing(
              [
                'subject' => 'SIPT Aufbautipp Nr. 9/2023',
                'template' => 'newsletter',
                'subscriber'  => $s,
                'attachments' => [
                  public_path() . '/storage/downloads/' . 'sipt-aufbau_10.pdf',
                ]
              ]
              )
            );
        $s->is_processed = 1;
        $s->save();
      }
      catch(\Throwable $e) {
        $s->error = $e;
        $s->is_processed = 1;
        $s->save();
      }
    }

    // Mailinglist "CONSULTANTS"
    $subscribers_consultants = \App\Models\MailinglistSubscriber::active()->where('mailinglist_id', env('MAILINGLIST_CONSULTANTS'))->get();
    $subscribers_consultants = collect($subscribers_consultants)->splice(0, 3);
    foreach($subscribers_consultants->all() as $s)
    {
      try {
        \Mail::to($s->email)
          ->send(
            new \App\Mail\Mailing(
              [
                'subject' => 'Einladung «Migration und Trauma» am 1./2. Dezember 2023',
                'template' => 'consultants',
                'subscriber'  => $s,
                // 'attachments' => [
                //   public_path() . '/storage/downloads/' . 'sipt.ch-Flyer_6._Impulstagung_Trauma_09.11.23.pdf',
                //   public_path() . '/storage/downloads/' . 'sipt.ch-Informationen_zu_den_Beitraegen_und_den_Referenten.pdf',
                // ]
              ]
              )
            );
        $s->is_processed = 1;
        $s->save();
      }
      catch(\Throwable $e) {
        $s->error = $e;
        $s->is_processed = 1;
        $s->save();
      }
    }

    // Mailinglist "EDUCATORS"
    $subscribers_educators = \App\Models\MailinglistSubscriber::active()->where('mailinglist_id', env('MAILINGLIST_EDUCATORS'))->get();
    $subscribers_educators = collect($subscribers_educators)->splice(0, 3);
    foreach($subscribers_educators->all() as $s)
    {
      try {
        \Mail::to($s->email)
          ->send(
            new \App\Mail\Mailing(
              [
                'subject' => 'Einladung «Migration und Trauma» am 1./2. Dezember 2023',
                'template' => 'educators',
                'subscriber'  => $s,
                // 'attachments' => [
                //   public_path() . '/storage/downloads/' . 'sipt.ch-Flyer_6._Impulstagung_Trauma_09.11.23.pdf',
                //   public_path() . '/storage/downloads/' . 'sipt.ch-Informationen_zu_den_Beitraegen_und_den_Referenten.pdf',
                // ]
              ]
            )
        );
        $s->is_processed = 1;
        $s->save();
      }
      catch(\Throwable $e) {
        $s->error = $e;
        $s->is_processed = 1;
        $s->save();
      }
    }

    // Mailinglist "PSYCHOTHERAPISTS"
    $subscribers_psychotherapists = \App\Models\MailinglistSubscriber::active()->where('mailinglist_id', env('MAILINGLIST_PSYCHOTHERAPISTS'))->get();
    $subscribers_psychotherapists = collect($subscribers_psychotherapists)->splice(0, 3);
    foreach($subscribers_psychotherapists->all() as $s)
    {
      try {
        \Mail::to($s->email)
          ->send(
            new \App\Mail\Mailing(
              [
                'subject' => 'Einladung «Migration und Trauma» am 1./2. Dezember 2023',
                'template' => 'psychotherapists',
                'subscriber'  => $s,
                // 'attachments' => [
                //   public_path() . '/storage/downloads/' . 'sipt.ch-Flyer_6._Impulstagung_Trauma_09.11.23.pdf',
                //   public_path() . '/storage/downloads/' . 'sipt.ch-Informationen_zu_den_Beitraegen_und_den_Referenten.pdf',
                // ]
              ]
            )
        );
        $s->is_processed = 1;
        $s->save();
      }
      catch(\Throwable $e) {
        $s->error = $e;
        $s->is_processed = 1;
        $s->save();
      }
    }
  }
}