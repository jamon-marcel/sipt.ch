<?php
namespace App\Http\Controllers;
use App\Models\CourseEvent;
use App\Events\CourseEventParticipantsList;
use App\Events\CourseList;
use Illuminate\Http\Request;

class DownloadController extends Controller
{

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
} 
