<?php
namespace App\Http\Controllers;
use App\Services\Document;
use App\Models\CourseEvent;
use App\Models\Student;
use App\Models\Download;
use App\Exports\SymposiumSubscribersExport;
use App\Exports\AnniversaryRegistrationsExport;
use App\Exports\StudentAddressesExport;
use App\Exports\TutorAddressesExport;
use App\Exports\VipAddressesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class DownloadController extends BaseController
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
    parent::__construct();
    $this->student = $student;
  }

  /**
   * Show the downloads page
   *
   * @return \Illuminate\Http\Response
   */

  public function index()
  {
    $downloads = Download::active()->orderBy('order')->get();
    return view($this->viewPath . 'index', ['downloads' => $downloads]);
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
   * Export the participant list
   *
   * @return \Illuminate\Http\Response
   */

  public function exportSymposiumParticipants()
  {
    return Excel::download(new SymposiumSubscribersExport, 'symposium_subscribers.xlsx');
  }

  /**
   * Download the anniversary participant list (PDF)
   *
   * @return \Illuminate\Http\Response
   */

  public function listAnniversaryParticipants()
  {
    $file = new Document();
    $file = $file->anniversaryParticipantList();
    return response()->download($file['path'], $file['name'], $this->headers);
  }

  /**
   * Export the anniversary participant list (Excel)
   *
   * @return \Illuminate\Http\Response
   */

  public function exportAnniversaryParticipants()
  {
    return Excel::download(new AnniversaryRegistrationsExport, 'sipt_20-jahre-teilnehmerliste.xlsx');
  }

  /**
   * Export the students address list
   *
   * @return \Illuminate\Http\Response
   */

  public function exportStudentAddresses()
  {
    return Excel::download(new StudentAddressesExport, 'sipt-studenten_adressen.xlsx');
  }

  /**
   * Export the tutors address list
   *
   * @return \Illuminate\Http\Response
   */

  public function exportTutorAddresses()
  {
    return Excel::download(new TutorAddressesExport, 'sipt-dozenten_adressen.xlsx');
  }

  /**
   * Export the tutors address list
   *
   * @return \Illuminate\Http\Response
   */

  public function exportVipAddresses()
  {
    return Excel::download(new VipAddressesExport, 'sipt-vip_adressen.xlsx');
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

  public function listCourses(Request $request)
  {
    $opts = [
      'dateStart' => $request->from,
      'dateEnd' => $request->to,
    ];
    $file = new Document();
    $file = $file->courseEventsList($opts);
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
   * @param String $studentId
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

  /**
   * Download course overview (all courses)
   *
   * @param String $studentId
   * @return \Illuminate\Http\Response
   */

  public function coursesOverview($studentId = NULL)
  {
    $student = auth()->user()->isAdmin()
                ? $this->student->with('user')->findOrFail($studentId)
                : $this->student->with('user')->authenticated(auth()->user()->id);
    
    $file = new Document();
    $file = $file->overview($student);
    return response()->download($file['path'], $file['name'], $this->headers);
  }

  /**
   * Download course overview (attended courses)
   *
   * @param String $studentId
   * @return \Illuminate\Http\Response
   */

  public function coursesAttended($studentId = NULL)
  {
    $student = auth()->user()->isAdmin()
                ? $this->student->with('user')->findOrFail($studentId)
                : $this->student->with('user')->authenticated(auth()->user()->id);
    
    $file = new Document();
    $file = $file->overview($student, 'attended');
    return response()->download($file['path'], $file['name'], $this->headers);
  }

} 
