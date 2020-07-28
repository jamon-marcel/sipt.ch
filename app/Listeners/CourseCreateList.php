<?php
namespace App\Listeners;
use App\Services\Document;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CourseCreateList
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct()
  {
  }

  /**
   * Handle the event.
   *
   * @param  CourseEventParticipantsList $event
   * @return void
   */
  public function handle()
  {
    $document = new Document();
    return $document->moduleList();
  }
}
