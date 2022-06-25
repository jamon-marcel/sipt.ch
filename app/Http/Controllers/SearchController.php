<?php
namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use App\Models\Course;
use Illuminate\Http\Request;

class SearchController extends BaseController
{
  protected $viewPath = 'web.pages.search.';

  /**
   * Constructor
   * 
   */
  public function __construct()
  {
    parent::__construct();
  }


  /**
   * Show the index page
   * 
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */

  public function index(Request $request)
  { 
    $results = [];
    if ($request->input('keyword'))
    {
      $results = Course::search($request->input('keyword'))->where('is_published', '1')->get();
    }
    return view($this->viewPath . 'index', ['results' => $results]);
  }

  /**
   * Export records
   * 
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */

  public function export()
  {
    $courses = Course::where('is_published', '1')->get();
    return response()->json($courses);
  }
}
