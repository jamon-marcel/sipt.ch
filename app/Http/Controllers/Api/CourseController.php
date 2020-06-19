<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\Course;
use App\Models\CourseEvent;
use App\Models\Training;
use App\Http\Requests\CourseStoreRequest;
use Illuminate\Http\Request;

class CourseController extends Controller
{

  public function __construct(Course $course, CourseEvent $courseEvent, Training $training)
  {
    $this->course      = $course;
    $this->courseEvent = $courseEvent;
    $this->training    = $training;
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $courses = $this->course->with('eventsUpcoming.dates.tutor')
                            ->with('eventsUpcoming.location')
                            ->get();
                            
    return new DataCollection($courses);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CourseStoreRequest $request)
  {
    $course = Course::create($request->all());
    $course->save();
    return response()->json(['CourseId' => $course->id]);
  }

  /**
   * Display the specified resource.
   *
   * @param Course $course
   * @return \Illuminate\Http\Response
   */
  public function show(Course $course)
  {
    $course = $this->course->with('events.location')
                           ->with('events.dates.tutor')
                           ->find($course->id);
    return response()->json($course);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param Course $course
   * @return \Illuminate\Http\Response
   */
  public function edit(Course $course)
  {
    return response()->json($this->course->find($course->id));
  }

  /**
   * Update the current student
   *
   * @param Course $course
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function update(Course $course, CourseStoreRequest $request)
  {
    $course->update($request->all());
    $course->save();
    return response()->json('successfully updated');
  }

  /**
   * Toggle the status of the specified resource.
   *
   * @param  Course $course
   * @return \Illuminate\Http\Response
   */
  public function toggle(Course $course)
  {
    $course->is_published = $course->is_published == 0 ? 1 : 0;
    $course->save();
    return response()->json($course->is_published);
  }

  /**
   * Remove the specified resource from storage.
   *
   * \Observers\CourseObserver observes and deletes child elements.
   * @param  Course $course
   * @return \Illuminate\Http\Response
   */
  public function destroy(Course $course)
  {
    $course->delete();
    return response()->json('successfully deleted');
  }

  /**
   * Get courses by training
   * 
   * @param Training $training
   * @return \Illuminate\Http\Response
   */
  public function getByTraining(Training $training)
  {
    return response()->json($training->courses);
  }

  /**
   * Get a single course with upcoming and completed events by given course
   * 
   * @param Course $course
   * @return \Illuminate\Http\Response
   */
  public function getCourseWithEvents(Course $course)
  {
    // Get course
    $course = $this->course->find($course->id);

    // Get events
    $events = [
      'upcoming'  => $this->courseEvent->with('dates.tutor', 'location')->upcoming()->where('course_id', $course->id),
      'completed' => $this->courseEvent->with('dates.tutor', 'location')->completed()->where('course_id', $course->id),
    ];
    $events = new DataCollection($events);
    return response()->json(['course' => $course, 'events' => $events]);
  }
}
