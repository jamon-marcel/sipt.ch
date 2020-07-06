<?php
namespace App\Listeners;
use App\Models\CourseEvent;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CourseCreateList
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
  public function handle()
  {
    $data = $this->courseEvent->with('course', 'students', 'dates.tutor')->orderBy('dateStart')->upcoming();
    
    // Create pdf
    $this->viewData['data'] = $data;
    $pdf = PDF::loadView('pdf.course.course-list', $this->viewData);

    // Set path & filename
    $path = public_path() . '/storage/temp/';
    $filename = 'modulliste-' . date('dmY', time());
    $file = $filename . '.pdf';
    $pdf->save($path . '/' . $file);

    return [
      'path' => $path . '/' . $file,
      'name' => $file
    ];

  }
}
