<?php
namespace App\Tasks;

class SymposiumNews
{
  public function __invoke()
  {
    $subscribers = \App\Models\SymposiumSubscriber::where('is_sent', '=', '0')->where('is_cancelled', '=', '0')->get();
    $subscribers = collect($subscribers)->splice(0, \Config::get('sipt.cron_chunk_size'));

    foreach($subscribers->all() as $s)
    {
      \Mail::to($s->email)
            ->bcc(\Config::get('sipt.email_copy'))
            ->send(
              new \App\Mail\SymposiumNews(
                [
                  'subscriber'  => $s,
                ]
          )
      );

      // Mark subscriber
      $s->is_sent = 1;
      $s->save();
    }
  }
}