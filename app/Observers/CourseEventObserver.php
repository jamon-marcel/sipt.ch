<?php
namespace App\Observers;
use App\Models\CourseEvent;

class CourseEventObserver
{
  /**
   * Handle the course event "created" event.
   *
   * @param  \App\CourseEvent  $courseEvent
   * @return void
   */
  public function created(CourseEvent $courseEvent)
  {
    //
  }

  /**
   * Handle the course event "updated" event.
   *
   * @param  \App\CourseEvent  $courseEvent
   * @return void
   */
  public function updated(CourseEvent $courseEvent)
  {
    //
  }

  /**
   * Handle the course event "deleted" event.
   *
   * @param  \App\CourseEvent  $courseEvent
   * @return void
   */
  public function deleted(CourseEvent $courseEvent)
  {
    //
  }

  /**
   * Handle the project "deleting" event.
   *
   * @param  \App\CourseEvent  $courseEvent
   * @return void
   */
  public function deleting(CourseEvent $courseEvent)
  {
    $courseEvent->dates()->delete();
  }

  /**
   * Handle the course event "restored" event.
   *
   * @param  \App\CourseEvent  $courseEvent
   * @return void
   */
  public function restored(CourseEvent $courseEvent)
  {
    //
  }

  /**
   * Handle the course event "force deleted" event.
   *
   * @param  \App\CourseEvent  $courseEvent
   * @return void
   */
  public function forceDeleted(CourseEvent $courseEvent)
  {
    //
  }
}
