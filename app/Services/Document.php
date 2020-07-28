<?php
namespace App\Services;
use PDF;
use App\Models\CourseEvent;
use Illuminate\Support\Facades\Storage;

class Document
{
  public function __construct()
  {
  }

  /**
   * Generate the 'attendance confirmation' for a given course_event and a given student
   * 
   * @param $courseEvent
   * @param $student
   */
  public function attendance($courseEvent, $student)
  {
    // Create pdf
    $this->viewData['courseEvent'] = $courseEvent;
    $this->viewData['student']     = $student;
    $pdf = PDF::loadView('pdf.course.confirmation', $this->viewData);

    // Set path & filename
    $path = public_path() . '/storage/temp/';
    $filename = 'sipt_kursbestaetigung_' . \AppHelper::slug($courseEvent->courseNumber) . '_' . \AppHelper::slug($student->fullName);
    $file = $filename . '.pdf';
    $pdf->save($path . $file);

    return [
      'path' => $path . $file,
      'name' => $file
    ];
  }

  /**
   * Generate the module list
   */

  public function moduleList()
  {
    $courseEvent = CourseEvent::with('course', 'students', 'dates.tutor')->orderBy('dateStart')->upcoming();

    // Create pdf
    $this->viewData['data'] = $courseEvent;
    $pdf = PDF::loadView('pdf.course.course-list', $this->viewData);

    // Set path & filename
    $path = public_path() . '/storage/temp/';
    $filename = 'modulliste-' . date('dmY', time());
    $file = $filename . '.pdf';
    $pdf->save($path . $file);

    return [
      'path' => $path . $file,
      'name' => $file
    ];
  }

  /**
   * Generate a participant list for a given courseEvent
   */

  public function participantList($courseEventId = NULL)
  {
    $courseEvent = CourseEvent::with('course', 'students', 'dates.tutor')->findOrFail($courseEventId);

    // Create pdf
    $this->viewData['data'] = $courseEvent;
    $pdf = PDF::loadView('pdf.course.participants-list', $this->viewData);

    // Set path & filename
    $path = public_path() . '/storage/temp/';
    $filename = \AppHelper::slug($courseEvent->course->title) . '-' . $courseEvent->course->number . '.' . date('dmy', strtotime($courseEvent->dateStart));
    $file = $filename . '.pdf';
    $pdf->save($path . $file);

    return [
      'path' => $path . $file,
      'name' => $file
    ];
  }

}