<?php
namespace App\Listeners;
use App\Events\CourseEventParticipantsList;
use App\Models\CourseEvent;
use PDF;
use Illuminate\Support\Facades\Storage;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CourseEventCreateParticipantsList
{
  /**
   * Create the event listener.
   *
   * @return void
   */
  public function __construct(CourseEvent $courseEvent)
  {
    $this->courseEvent = $courseEvent;
  }

  /**
   * Handle the event.
   *
   * @param  CourseEventParticipantsList $event
   * @return void
   */
  public function handle(CourseEventParticipantsList $event)
  {
    $courseEvent = $event->courseEvent;
    $data = $this->courseEvent->with('course', 'students', 'dates.tutor')->findOrFail($courseEvent->id);

    // Create pdf
    $this->viewData['data'] = $data;
    $pdf = PDF::loadView('pdf.course.participants-list', $this->viewData);

    // Set path & filename
    $path = public_path() . '/storage/temp/';
    $filename = \AppHelper::slug($data->course->title) . '-' . $data->course->number . '.' . date('dmy', strtotime($data->dateStart));
    $file = $filename . '.pdf';
    $pdf->save($path . '/' . $file);

    return [
      'path' => $path . '/' . $file,
      'name' => $file
    ];


  }
}
