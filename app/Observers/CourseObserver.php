<?php
namespace App\Observers;
use App\Models\Course;

class CourseObserver
{
  /**
   * Handle the course event "created" event.
   *
   * @param  \App\Course  $course
   * @return void
   */
  public function created(Course $course)
  {
    //
  }

  /**
   * Handle the course event "updated" event.
   *
   * @param  \App\Course  $course
   * @return void
   */
  public function updated(Course $course)
  {
    //
  }

  /**
   * Handle the course event "deleted" event.
   *
   * @param  \App\Course  $course
   * @return void
   */
  public function deleted(Course $course)
  {
    //
  }

  /**
   * Handle the project "deleting" event.
   *
   * @param  \App\Course  $course
   * @return void
   */
  public function deleting(Course $course)
  {
    // Delete 'event.dates' first
    $course_events = $course->with('events.dates')->find($course->id);
    foreach($course_events->events as $event)
    {
      $ids = collect($event->dates)->pluck('id');
      $event->dates()->whereIn('id', $ids)->delete();
    }

    // Delete 'events'
    $course->events()->delete();
  }

  /**
   * Handle the course event "restored" event.
   *
   * @param  \App\Course  $course
   * @return void
   */
  public function restored(Course $course)
  {
    //
  }

  /**
   * Handle the course event "force deleted" event.
   *
   * @param  \App\Course  $course
   * @return void
   */
  public function forceDeleted(Course $course)
  {
    //
  }
}
