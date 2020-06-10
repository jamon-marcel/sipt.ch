<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\Course;
use App\Models\CourseEvent;
use App\Models\CourseEventDate;
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
   * Get all course events by its parent id
   *
   * @param Course $course
   * @return \Illuminate\Http\Response
   */
  public function index(Course $course)
  {
    $courseEvent = $this->courseEvent
                        ->with('course')
                        ->with('location')
                        ->with('dates')
                        ->where('course_id', '=', $course->id)
                        ->get();
    return response()->json($courseEvent);
  }

  /**
   * Get a single course event
   *
   * @param CourseEvent $courseEvent
   * @return \Illuminate\Http\Response
   */
  public function show(CourseEvent $courseEvent)
  {
    $courseEvent = $this->courseEvent
                        ->with('course')
                        ->with('location')
                        ->with('dates')
                        ->find($courseEvent->id);
    return response()->json($courseEvent);
  }

  /**
   * Store a newly created resource in storage.
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
   * Show the form for editing the specified resource.
   *
   * @param CourseEvent $courseEvent
   * @return \Illuminate\Http\Response
   */
  public function edit(CourseEvent $courseEvent)
  {
    $courseEvent = $this->courseEvent
                        ->with('course')
                        ->with('location')
                        ->with('dates')
                        ->find($courseEvent->id);    
    return response()->json($courseEvent);
  }

  /**
   * Update the current student
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

    return response()->json('successfully updated');
  }

  /**
   * Toggle the status of the specified resource.
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
   * Set 'is_cancelled' of the specified resource.
   *
   * @param  CourseEvent $courseEvent
   * @return \Illuminate\Http\Response
   */
  public function cancel(CourseEvent $courseEvent)
  {
    // @todo: send mail to student/tutor
    $courseEvent->is_cancelled = 1;
    $courseEvent->is_published = 0;
    $courseEvent->save();
    return response()->json($courseEvent->is_cancelled);
  }

  /**
   * Remove the specified resource from storage.
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
}
