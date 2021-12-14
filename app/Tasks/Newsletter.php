<?php
namespace App\Tasks;

class Newsletter
{
  public function __invoke()
  {
    $subscribers = \App\Models\NewsletterSubscriber::where('is_done', '=', '0')->where('is_confirmed', '=', '1')->get();
    $subscribers = collect($subscribers)->splice(0, \Config::get('sipt.cron_chunk_size'));

    foreach($subscribers->all() as $s)
    {
      \Mail::to($s->email)
            ->send(
              new \App\Mail\Newsletter(
                [
                  'subscriber'  => $s,
                  'attachments' => [
                    public_path() . '/storage/downloads/' . 'sipt-aufbau_06.pdf',
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