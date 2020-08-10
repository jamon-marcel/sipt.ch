<?php
namespace App\Services;
use PDF;
use App\Models\CourseEvent;
use App\Models\SymposiumSubscriber;
use Illuminate\Support\Facades\Storage;

class Document
{
  public function __construct()
  {
  }

  /**
   * Create the 'invitation' for a given course_event and a given student
   * 
   * @param $courseEvent
   * @param $student
   * @return Array
   */
  public function invitation($courseEvent, $student)
  {
    // Create pdf
    $this->viewData['courseEvent'] = $courseEvent;
    $this->viewData['student']     = $student;
    $pdf = PDF::loadView('pdf.course.invitation', $this->viewData);

    // Set path & filename
    $path = public_path() . '/storage/temp/';
    $filename = 'sipt.ch-kurseinladung-' . \AppHelper::slug($courseEvent->courseNumber) . '_' . \AppHelper::slug($student->fullName);
    $file = $filename . '.pdf';
    $pdf->save($path . $file);

    return [
      'path' => $path . $file,
      'name' => $file
    ];
  }

  /**
   * Create the 'attendance confirmation' for a given course_event and a given student
   * 
   * @param $courseEvent
   * @param $student
   * @return Array
   */

  public function attendance($courseEvent, $student)
  {
    // Create pdf
    $this->viewData['courseEvent'] = $courseEvent;
    $this->viewData['student']     = $student;
    $pdf = PDF::loadView('pdf.course.confirmation', $this->viewData);

    // Set path & filename
    $path = public_path() . '/storage/temp/';
    $filename = 'sipt.ch-kursbestaetigung-' . \AppHelper::slug($courseEvent->courseNumber) . '_' . \AppHelper::slug($student->fullName);
    $file = $filename . '.pdf';
    $pdf->save($path . $file);

    return [
      'path' => $path . $file,
      'name' => $file
    ];
  }

  /**
   * Create the course events list for all course events
   * 
   * @return Array
   */

  public function courseEventsList()
  {
    $courseEvents = CourseEvent::with('course', 'students', 'dates.tutor')->orderBy('dateStart')->upcoming();

    // Create pdf
    $this->viewData['data'] = $courseEvents;
    $pdf = PDF::loadView('pdf.lists.courses', $this->viewData);

    // Set path & filename
    $path = public_path() . '/storage/temp/';
    $filename = 'sipt.ch-modulliste-' . date('dmY', time()) . '-' . \Str::random(8);
    $file = $filename . '.pdf';
    $pdf->save($path . $file);

    return [
      'path' => $path . $file,
      'name' => $file
    ];
  }

  /**
   * Create a participant list for a given course event
   * 
   * @param $courseEventId
   * @return Array
   */

  public function participantList($courseEventId = NULL)
  {
    $courseEvent = CourseEvent::with('course', 'students', 'dates.tutor')->findOrFail($courseEventId);
    $courseEvent->students = $courseEvent->students->sortByDesc('pivot.created_at');

    // Create pdf
    $this->viewData['data'] = $courseEvent;
    $pdf = PDF::loadView('pdf.lists.participants', $this->viewData);

    // Set path & filename
    $path = public_path() . '/storage/temp/';
    $filename = 'sipt.ch-teilnehmerliste-' . \AppHelper::slug($courseEvent->course->title) . '-' . $courseEvent->course->number . '.' . date('dmy', strtotime($courseEvent->dateStart)) . '-' . \Str::random(8);
    $file = $filename . '.pdf';
    $pdf->save($path . $file);

    return [
      'path' => $path . $file,
      'name' => $file
    ];
  }

  /**
   * Create a participant list for a given course event
   * 
   * @param $courseEventId
   * @return Array
   */

  public function symposiumParticipantList($courseEventId = NULL)
  {
    $subscribers = SymposiumSubscriber::with('symposium')->orderBy('created_at', 'DESC')->where('is_cancelled', '=', 0)->get();

    // Create pdf
    $this->viewData['subscribers'] = $subscribers;
    $pdf = PDF::loadView('pdf.lists.symposium', $this->viewData);

    // Set path & filename
    $path = public_path() . '/storage/temp/';
    $filename = 'sipt.ch-teilnehmerliste-fachtagung-100.101020' . '-' . \Str::random(8);
    $file = $filename . '.pdf';
    $pdf->save($path . $file);

    return [
      'path' => $path . $file,
      'name' => $file
    ];
  }

  /**
   * Create a attendance list for a given course event
   * 
   * @param $courseEventId
   * @return Array
   */

  public function attendanceList($courseEventId = NULL)
  {
    $courseEvent = CourseEvent::with('course', 'students', 'dates.tutor')->findOrFail($courseEventId);

    // Create pdf
    $this->viewData['data'] = $courseEvent;
    $pdf = PDF::loadView('pdf.lists.attendance', $this->viewData);

    // Set path & filename
    $path = public_path() . '/storage/temp/';
    $filename = 'sipt.ch-anwesenheitsliste-' . \AppHelper::slug($courseEvent->course->title) . '-' . $courseEvent->course->number . '.' . date('dmy', strtotime($courseEvent->dateStart)) . '-' . \Str::random(8);
    $file = $filename . '.pdf';
    $pdf->save($path . $file);

    return [
      'path' => $path . $file,
      'name' => $file
    ];
  }

}