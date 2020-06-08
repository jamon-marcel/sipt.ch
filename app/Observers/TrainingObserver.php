<?php
namespace App\Observers;
use App\Models\Training;

class TrainingObserver
{
  /**
   * Handle the training event "created" event.
   *
   * @param  \App\Training  $training
   * @return void
   */
  public function created(Training $training)
  {
    //
  }

  /**
   * Handle the training event "updated" event.
   *
   * @param  \App\Training  $training
   * @return void
   */
  public function updated(Training $training)
  {
    //
  }

  /**
   * Handle the training event "deleted" event.
   *
   * @param  \App\Training  $training
   * @return void
   */
  public function deleted(Training $training)
  {
    //
  }

  /**
   * Handle the project "deleting" event.
   *
   * @param  \App\Training  $training
   * @return void
   */
  public function deleting(Training $training)
  { 
    // Remove 'course_training' entries
    $training->courses()->detach();
  }

  /**
   * Handle the training event "restored" event.
   *
   * @param  \App\Training  $training
   * @return void
   */
  public function restored(Training $training)
  {
    //
  }

  /**
   * Handle the training event "force deleted" event.
   *
   * @param  \App\Training  $training
   * @return void
   */
  public function forceDeleted(Training $training)
  {
    //
  }
}
