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
   * Get a list of courses
   *
   * @return \Illuminate\Http\Response
   */
  public function get()
  {
    $courses = $this->course->with('eventsUpcoming.dates.tutor', 'eventsUpcoming.location')->orderBy('number')->get();
    return new DataCollection($courses);
  }

  /**
   * Get a single course for a given course
   *
   * @param Course $course
   * @return \Illuminate\Http\Response
   */
  public function find(Course $course)
  {
    $course = $this->course->with('events.location', 'events.dates.tutor')->find($course->id);
    return response()->json($course);
  }

  /**
   * Store a newly created course
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CourseStoreRequest $request)
  {
    $course = Course::create($request->all());
    $course->save();
    return response()->json(['courseId' => $course->id]);
  }

  /**
   * Update the current course
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
   * Toggle the status of a given course
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
   * Remove a course by a given course
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
   * Get courses by a given training
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
  public function getWithEvents(Course $course)
  {
    // Get course
    $course = $this->course->find($course->id);

    // Get events
    $events = [
      'upcoming'  => $this->courseEvent->with('dates.tutor', 'location', 'students')->upcoming()->where('course_id', $course->id),
      'completed' => $this->courseEvent->with('dates.tutor', 'location', 'students')->completed()->where('course_id', $course->id),
    ];
    $events = new DataCollection($events);
    return response()->json(['course' => $course, 'events' => $events]);
  }
}
