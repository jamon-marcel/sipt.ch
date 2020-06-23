<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\CourseEventDate;
use Illuminate\Http\Request;

class CourseEventDateController extends Controller
{

  public function __construct(CourseEventDate $courseEventDate)
  {
    $this->courseEventDate = $courseEventDate;
  }

  /**
   * Remove a course event date by given course event date
   *
   * @param  CourseEventDate $courseEventDate
   * @return \Illuminate\Http\Response
   */
  public function destroy(CourseEventDate $courseEventDate)
  {
    $courseEventDate->delete();
    return response()->json('successfully deleted');
  }
}
