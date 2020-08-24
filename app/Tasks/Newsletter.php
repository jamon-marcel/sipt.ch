<?php
namespace App\Tasks;

class Newsletter
{
  public function __invoke()
  {
    $subscribers = \App\Models\NewsletterSubscriber::where('is_done', '=', '0')->get();
    $subscribers = collect($subscribers)->splice(0, \Config::get('sipt.cron_chunk_size'));

    foreach($subscribers->all() as $s)
    {
      \Mail::to($s->email)
            //->bcc(\Config::get('sipt.email_copy'))
            ->send(
              new \App\Mail\Newsletter(
                [
                  'subscriber'  => $s,
                  'attachments' => [
                    public_path() . '/storage/downloads/' . 'Barwinski_Steuerungsprozesse.pdf',
                  ]
                ]
          )
      );

      // Mark subscriber
      $s->is_done = 1;
      $s->save();
    }
  }
}