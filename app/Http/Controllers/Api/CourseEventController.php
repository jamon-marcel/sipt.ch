<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\Course;
use App\Models\CourseEvent;
use App\Models\CourseEventDate;
use App\Events\CourseEventCancelledByAdministrator;
use App\Events\CourseEventClosed;
use App\Http\Requests\CourseEventStoreRequest;
use Illuminate\Http\Request;

class CourseEventController extends Controller
{

  public function __construct(Course $course, CourseEvent $courseEvent)
  {
    $this->course = $course;
    $this->courseEvent = $courseEvent;
  }

  /**
   * Fetch all upcoming course events
   *
   * @param String $constraint
   * @return \Illuminate\Http\Response
   */
  public function fetch($constraint = NULL)
  {
    if ($constraint == 'upcoming')
    {
      $courseEvents = $this->courseEvent->with('course', 'location', 'dates', 'students')->orderBy('dateStart')->upcoming();
      return new DataCollection($courseEvents);
    }

    $courseEvents = $this->courseEvent->with('course', 'location', 'dates', 'students')->orderBy('dateStart')->get();
    return new DataCollection($courseEvents);
  }


  /**
   * Get a list of course events by a given course
   *
   * @param Course $course
   * @return \Illuminate\Http\Response
   */
  public function get(Course $course)
  {
    $courseEvent = $this->courseEvent->with('course', 'location', 'dates')->where('course_id', '=', $course->id)->get();
    return response()->json($courseEvent);
  }

  /**
   * Get a course event for a given course event
   *
   * @param CourseEvent $courseEvent
   * @return \Illuminate\Http\Response
   */
  public function find(CourseEvent $courseEvent)
  {
    $courseEvent = $this->courseEvent->with('course', 'location', 'dates.tutor', 'students.user', 'documents')->find($courseEvent->id);
    return response()->json($courseEvent);
  }

  /**
   * Store a newly created course event
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CourseEventStoreRequest $request)
  {
    // Course Event
    $courseEvent = CourseEvent::create($request->all());
    $courseEvent->save();

    // Course Event Dates
    if (!empty($request->dates))
    {
      $dateStart = collect($request->dates)->sortBy('date')->first();
      $courseEvent->dateStart = $dateStart['date'];
      $courseEvent->save();
      
      foreach($request->dates as $d)
      {
        $courseEventDate = new CourseEventDate([
          'course_event_id'  => $courseEvent->id,
          'date'             => $d['date'],
          'timeStart'        => $d['timeStart'],
          'timeEnd'          => $d['timeEnd'],
          'tutor_id'         => $d['tutor_id'],
        ]);
        $courseEventDate->save();
      }
    }
    return response()->json(['courseEventId' => $courseEvent->id]);
  }

  /**
   * Update the current course event
   *
   * @param CourseEvent $courseEvent
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function update(CourseEvent $courseEvent, CourseEventStoreRequest $request)
  {
    // Course Event
    $courseEvent->update($request->all());

    // Course Event Dates
    if (!empty($request->dates))
    {
      $dateStart = collect($request->dates)->sortBy('date')->first();
      $courseEvent->dateStart = $dateStart['date'];

      foreach($request->dates as $d)
      { 
        $courseEventDate = CourseEventDate::updateOrCreate(
          ['id' => isset($d['id']) ? $d['id'] : NULL], 
          [
            'course_event_id'  => $courseEvent->id,
            'date'             => $d['date'],
            'timeStart'        => $d['timeStart'],
            'timeEnd'          => $d['timeEnd'],
            'tutor_id'         => $d['tutor_id'],
          ]
        );
      }
    }
    $courseEvent->save();

    // call event if course event is cancelled
    if ($courseEvent->is_cancelled == 1)
    {
      event(new CourseEventCancelledByAdministrator($courseEvent));
    }
    return response()->json('successfully updated');
  }

  /**
   * Toggle the status course event by given course event
   *
   * @param  CourseEvent $courseEvent
   * @return \Illuminate\Http\Response
   */
  public function toggle(CourseEvent $courseEvent)
  {
    $courseEvent->is_published = $courseEvent->is_published == 0 ? 1 : 0;
    $courseEvent->save();
    return response()->json($courseEvent->is_published);
  }

  /**
   * Set attributes 'cancelled' and 'published' and by given course event
   *
   * @param  CourseEvent $courseEvent
   * @return \Illuminate\Http\Response
   */
  public function cancel(CourseEvent $courseEvent)
  {
    $courseEvent->is_cancelled = 1;
    $courseEvent->is_published = 0;
    $courseEvent->save();
    return response()->json($courseEvent->is_cancelled);
  }

  /**
   * Set attributes 'is_closed' and 'is_bookable' and by given course event
   *
   * @param  CourseEvent $courseEvent
   * @return \Illuminate\Http\Response
   */
  public function close(CourseEvent $courseEvent)
  {
    $courseEvent->is_closed = 1;
    $courseEvent->is_bookable = 0;
    $courseEvent->save();
    event(new CourseEventClosed($courseEvent));
    return response()->json($courseEvent->is_closed);
  }

  /**
   * Set attributes 'is_closed' and 'is_bookable' and by given course event
   *
   * @param  CourseEvent $courseEvent
   * @return \Illuminate\Http\Response
   */
  public function open(CourseEvent $courseEvent)
  {
    $courseEvent->is_closed = 0;
    $courseEvent->is_bookable = 1;
    $courseEvent->save();
    return response()->json($courseEvent->is_closed);
  }

  /**
   * Remove a course by given course
   *
   * \Observers\CourseEventObserver observes and deletes child elements.
   * @param  Course $course
   * @return \Illuminate\Http\Response
   */
  public function destroy(CourseEvent $courseEvent)
  {
    $courseEvent->delete();
    return response()->json('successfully deleted');
  }

  /**
   * Get course events by given course
   * 
   * @param Course $course
   * @return \Illuminate\Http\Response
   */
  public function getByCourse(Course $course)
  {
    $courseEvents = $this->course->with('eventsBookable.location')
                                 ->with('eventsBookable.dates.tutor')
                                 ->find($course->id);
    return response()->json($courseEvents);
  }
}
