<?php
namespace App\Http\Controllers;
use App\Services\Document;
use App\Models\CourseEvent;
use App\Models\Student;
use App\Events\CourseEventParticipantsList;
use App\Events\CourseList;
use Illuminate\Http\Request;

class DownloadController extends Controller
{

  public function __construct(Student $student)
  {
    $this->student = $student;
  }

  public function participants(CourseEvent $courseEvent)
  {
    $file = event(new CourseEventParticipantsList($courseEvent));
    return response()->download($file[0]['path'], $file[0]['name'], ['Content-Type: application/pdf']);
  }

  public function courses()
  {
    $file = event(new CourseList());
    return response()->download($file[0]['path'], $file[0]['name'], ['Content-Type: application/pdf']);
  }

  public function confirmation(CourseEvent $courseEvent)
  {
    $student = $this->student->with('user')->authenticated(auth()->user()->id);
    $file = new Document();
    $file = $file->attendance($courseEvent, $student);
    return response()->download($file['path'], $file['name'], ['Content-Type: application/pdf']);
  }
} 
