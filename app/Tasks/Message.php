<?php
namespace App\Tasks;

class Message
{
  public function __invoke()
  {
    $recipients = \App\Models\MessageLog::where('is_sent', '=', '0')->with('message')->get();
    $recipients = collect($recipients)->splice(0, \Config::get('sipt.cron_chunk_size'));

    foreach($recipients->all() as $r)
    {
      $courseEvent = \App\Models\CourseEvent::with('course', 'dates')->find($r->message->course_event_id);
      if ($courseEvent)
      {
	      \Mail::to($r->email)
	            ->bcc(\Config::get('sipt.email_copy'))
	            ->send(
	              new \App\Mail\Message(
	                [
	                  'recipient' => $r,
	                  'message' => $r->message,
	                  'courseEvent' => $courseEvent,
	                ]
	            )
	      );
	
	      // Mark recipient
	      $r->is_sent = 1;
	      $r->save();	      
      }
      else
      {
	      \Log::error('Course Event ' . $r->message->course_event_id . ' not found!');
				$r->is_sent = 1;
	      $r->save();	  
      }
    }
  }
}