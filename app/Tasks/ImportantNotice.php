<?php
namespace App\Tasks;

class ImportantNotice
{
  public function __invoke()
  {
    $subscribers = \App\Models\ImportantNoticeSubscriber::where('is_done', '=', '0')->get();
    $subscribers = collect($subscribers)->splice(0, \Config::get('sipt.cron_chunk_size'));

    foreach($subscribers->all() as $s)
    {
      try
      {
        \Mail::to($s->email)->send(new \App\Mail\ImportantNotice());
        $s->is_done = 1;
        $s->save();
      }
      catch(\Throwable $e)
      {
        $s->is_done = 1;
        $s->is_failed = 1;
        $s->save();
        \Log::error($e);
      }
    }
  }
}