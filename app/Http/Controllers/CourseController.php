<?php
namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use App\Models\Training;
use App\Models\TrainingCategory;
use App\Models\CourseEvent;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends BaseController
{
  protected $viewPath = 'web.pages.course.';

  protected $training;

  public function __construct(Training $training, TrainingCategory $trainingCategory, Course $course, CourseEvent $courseEvent)
  {
    parent::__construct();
    $this->training = $training;
    $this->trainingCategory = $trainingCategory;
    $this->course = $course;
    $this->courseEvent = $courseEvent;
  }

  /**
   * Show a course by given course
   *
   * @param String $slug
   * @param Course $course
   * @return \Illuminate\Http\Response
   */

  public function show($slug = NULL, Course $course)
  { 
    $course = $this->course->with('eventsBookable.location', 'eventsBookable.dates.tutor')->findOrFail($course->id);
    return 
      view($this->viewPath . 'show', 
        [
          'course' => $course,
        ]
      );
  }

  /**
   * Store a course event to the users session
   *
   * @param CourseEvent $courseEvent
   * @return \Illuminate\Http\Response
   */

  public function add(Request $request, CourseEvent $courseEvent)
  { 
    // Get the course event
    $courseEvent = $this->courseEvent->with('course', 'dates')->find($courseEvent->id);

    // Create bookings array
    $bookings = $request->session()->has('bookings') ? $request->session()->get('bookings') : [];

    // Create collection
    $collection = collect($bookings);

    // Prep booking data
    $booking = [
      'id' => $courseEvent->id,
      'cost' => $courseEvent->course->cost,
      'title' => $courseEvent->course->title,
      'date' => \AppHelper::datesToString($courseEvent->dates)
    ];

    // Add to collection
    $collection->push($booking);

    // Make sure we only have unique items
    $unique_bookings = $collection->unique('id');

    // Store in session
    $request->session()->put('bookings', $unique_bookings);

    return response()->json($request->session()->get('bookings'));
  }

  /**
   * Remove a course event from the users session
   *
   * @param CourseEvent $courseEvent
   * @return \Illuminate\Http\Response
   */

  public function destroy(Request $request, CourseEvent $courseEvent)
  { 
    // Get the course event
    $courseEvent = $this->courseEvent->with('course', 'dates')->find($courseEvent->id);

    // Create bookings array
    $bookings = $request->session()->has('bookings') ? $request->session()->get('bookings') : [];

    // Create collection
    $collection = collect($bookings);

    // Remove item from collection
    $bookings = $collection->filter(function($item) use ($courseEvent) {
      return $item['id'] != $courseEvent->id;
    });
  
    // Store in session
    $request->session()->put('bookings', $bookings);

    return response()->json($request->session()->get('bookings'));
  }

}
