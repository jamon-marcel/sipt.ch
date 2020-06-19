<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\Tutor;
use App\Models\TutorImage;
use App\Models\CourseEvent;
use App\Models\User;
use App\Http\Requests\TutorStoreRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TutorController extends Controller
{
  public function __construct(Tutor $tutor, TutorImage $tutorImage, CourseEvent $courseEvent)
  {
    $this->tutor      = $tutor;
    $this->tutorImage = $tutorImage;
    $this->courseEvent = $courseEvent;
    $this->authorizeResource(Tutor::class, 'tutor');
  }

  /**
   * Get all Tutors
   * 
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return new DataCollection($this->tutor->get());
  }

  /**
   * Get all active Tutors
   * 
   * @return \Illuminate\Http\Response
   */
  public function active()
  {
    return new DataCollection($this->tutor->active()->orderBy('name')->get());
  }

  /**
   * Get current Tutor
   * 
   * @param Tutor $tutor
   * @return \Illuminate\Http\Response
   */
  public function show(Tutor $tutor)
  {
    return response()->json($this->tutor->with('user')->find($tutor->id));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */

  public function store(TutorStoreRequest $request)
  {
    // Store the tutor
    $tutor = Tutor::create($request->except('user.email'));
    $tutor->save();
    return response()->json(['tutorId' => $tutor->id]);
  }

  /**
   * Edit current Tutor
   * 
   * @param Tutor $tutor
   * @return \Illuminate\Http\Response
   */
  public function edit(Tutor $tutor)
  {
    return response()->json($this->tutor->with('user')->with('images')->find($tutor->id));
  }

  /**
   * Update the current Tutor
   *
   * @param Tutor $tutor
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function update(Tutor $tutor, TutorStoreRequest $request)
  {
    // Update tutor
    $tutor->update($request->except('user.email'));
    $tutor->save();

    // Update/add images
    if (!empty($request->images))
    {
      foreach($request->images as $i)
      {
        $image = TutorImage::updateOrCreate(
          ['id' => $i['id']], 
          [
            'tutor_id'    => $tutor->id,
            'name'        => $i['name'],
            'caption'     => $i['caption'],
            'coords_w'    => $i['coords_w'] ? round($i['coords_w'], 12) : NULL,
            'coords_h'    => $i['coords_h'] ? round($i['coords_h'], 12) : NULL,
            'coords_x'    => $i['coords_x'] ? round($i['coords_x'], 12) : NULL,
            'coords_y'    => $i['coords_y'] ? round($i['coords_y'], 12) : NULL,
            'publish'     => $i['publish'] ? $i['publish'] : 0,
            'orientation' => $i['orientation'] ? $i['orientation'] : NULL,
          ]
        );
      }
    }


    return response()->json('successfully updated');
  }

  /**
   * Toggle the status of the specified resource.
   *
   * @param  Tutor $tutor
   * @return \Illuminate\Http\Response
   */
  public function toggle(Tutor $tutor)
  {
    $tutor->is_published = $tutor->is_published == 0 ? 1 : 0;
    $tutor->save();
    return response()->json($tutor->is_published);
  }

  /**
   * Remove the specified record.
   *
   * @param  Tutor $tutor
   * @return \Illuminate\Http\Response
   */
  public function destroy(Tutor $tutor)
  {
    $tutor->delete();
    return response()->json('successfully deleted');
  }

  /**
   * Get a students profile by given tutor (admin) or by authenticated user
   *
   * @param  Tutor $tutor
   * @return \Illuminate\Http\Response
   */
  public function profile(Tutor $tutor)
  {
    // Get profile
    $profile = auth()->user()->isAdmin()
                ? $this->tutor->with('user')->findOrFail($tutor->id)
                : $this->tutor->with('user')->authenticated(auth()->user()->id);
    return response()->json($profile);
  }

  /**
   * Remove the specified record.
   *
   * @param  Tutor $tutor
   * @return \Illuminate\Http\Response
   */

  public function courseEvents(Tutor $tutor)
  {
    $tutor = $this->tutor->authenticated(auth()->user()->id);
    $courseEvents = $tutor->courseEventDates('upcoming')
                          ->with('courseEvent.course', 'courseEvent.location')
                          ->get();

    return response()->json(['tutor' => $tutor, 'courseEvents' => $courseEvents]);
  }

  /**
   * Get a single courseEvent for a tutor
   *
   * @param CourseEvent $courseEvent
   * @return \Illuminate\Http\Response
   */

  public function courseEvent(CourseEvent $courseEvent)
  { 
    // Get student by logged in user
    $tutor = $this->tutor->authenticated(auth()->user()->id);

    // Get courseEvent with all related data
    $courseEvent = $tutor->courseEventDates()
                         ->with('courseEvent.course', 'courseEvent.location', 'courseEvent.dates.tutor')
                         ->where('course_event_id', '=', $courseEvent->id)
                         ->get()
                         ->first();

    return response()->json($courseEvent);
  }
}
