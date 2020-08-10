<?php
namespace App\Http\Controllers;
use App\Services\Document;
use App\Models\CourseEvent;
use App\Models\Student;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
  protected $viewPath = 'web.pages.downloads.';
  
  protected $headers = [
    'Content-Type: application/pdf',
    'Cache-Control: no-store, no-cache, must-revalidate',
    'Expires: Sun, 01 Jan 2014 00:00:00 GMT',
    'Pragma: no-cache'
  ];

  public function __construct(Student $student)
  {
    $this->student = $student;
  }

  /**
   * Show the about page
   *
   * @return \Illuminate\Http\Response
   */
   
  public function index()
  {
    return view($this->viewPath . 'index');
  }

  /**
   * Download the participant list
   *
   * @return \Illuminate\Http\Response
   */

  public function listParticipants(CourseEvent $courseEvent)
  {
    $file = new Document();
    $file = $file->participantList($courseEvent->id);
    return response()->download($file['path'], $file['name'], $this->headers);
  }

  /**
   * Download the participant list
   *
   * @return \Illuminate\Http\Response
   */

  public function listSymposiumParticipants()
  {
    $file = new Document();
    $file = $file->symposiumParticipantList();
    return response()->download($file['path'], $file['name'], $this->headers);
  }

  /**
   * Download the list of attendees
   *
   * @return \Illuminate\Http\Response
   */

  public function listAttendances(CourseEvent $courseEvent)
  {
    $file = new Document();
    $file = $file->attendanceList($courseEvent->id);
    return response()->download($file['path'], $file['name'], $this->headers);
  }

  /**
   * Download the list of course
   *
   * @return \Illuminate\Http\Response
   */

  public function listCourses()
  {
    $file = new Document();
    $file = $file->courseEventsList();
    return response()->download($file['path'], $file['name'], $this->headers);
  }

  /**
   * Download attendance confirmation
   *
   * @param CourseEvent $courseEvent
   * @param String studentId
   * @return \Illuminate\Http\Response
   */

  public function confirmation(CourseEvent $courseEvent, $studentId = NULL)
  {
    $student = auth()->user()->isAdmin()
                ? $this->student->with('user')->findOrFail($studentId)
                : $this->student->with('user')->authenticated(auth()->user()->id);

    $file = new Document();
    $file = $file->attendance($courseEvent, $student);
    
    return response()->download($file['path'], $file['name'], $this->headers);
  }

  /**
   * Download invitation
   *
   * @param CourseEvent $courseEvent
   * @param String studentId
   * @return \Illuminate\Http\Response
   */

  public function invitation(CourseEvent $courseEvent, $studentId = NULL)
  {
    $student = auth()->user()->isAdmin()
                ? $this->student->with('user')->findOrFail($studentId)
                : $this->student->with('user')->authenticated(auth()->user()->id);

    $file = new Document();
    $file = $file->invitation($courseEvent, $student);
    
    return response()->download($file['path'], $file['name'], $this->headers);
  }

} 
