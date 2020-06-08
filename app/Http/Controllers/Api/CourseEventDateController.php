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
   * Remove the specified resource from storage.
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
