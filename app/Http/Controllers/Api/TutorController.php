<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\Tutor;
use App\Models\TutorImage;
use App\Models\CourseEvent;
use App\Models\User;
use App\Models\Mailinglist;
use App\Events\TutorStored;
use App\Http\Requests\TutorStoreRequest;
use App\Http\Requests\TutorUpdateRequest;
use App\Actions\Mailinglist\CreateSubscriber;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TutorController extends Controller
{
  public function __construct(
    Tutor $tutor, 
    TutorImage $tutorImage, 
    CourseEvent $courseEvent, 
    User $user,
    CreateSubscriber $createSubscriber)
  {
    $this->tutor                 = $tutor;
    $this->tutorImage            = $tutorImage;
    $this->courseEvent           = $courseEvent;
    $this->user                  = $user;
    $this->createSubscriber      = $createSubscriber;
    $this->authorizeResource(Tutor::class, 'tutor');
  }

  /**
   * Get a list of Tutors
   * 
   * @param String $constraint
   * @return \Illuminate\Http\Response
   */
  public function get($constraint = NULL)
  {
    if ($constraint == 'active')
    {
      return new DataCollection($this->tutor->active()->get());
    }
    return new DataCollection($this->tutor->orderBy('name')->with('user')->get());
  }

  /**
   * Get a single tutor for a given tutor or authenticated tutor
   * 
   * @param Tutor $tutor
   * @return \Illuminate\Http\Response
   */
  public function find(Tutor $tutor)
  {
    $tutor = auth()->user()->isAdmin()
              ? $this->tutor->with('user')->with('images')->findOrFail($tutor->id)
              : $this->tutor->with('user')->with('images')->authenticated(auth()->user()->id);

    return response()->json($tutor);
  }

  /**
   * Update a tutor for a given tutor or authenticated tutor
   *
   * @param Tutor $tutor
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function update(Tutor $tutor, TutorUpdateRequest $request)
  {
    $tutor = auth()->user()->isAdmin()
              ? $this->tutor->with('user')->findOrFail($tutor->id)
              : $this->tutor->with('user')->authenticated(auth()->user()->id);

    // Save changes
    $tutor->update($request->except('email'));
    $tutor->save();

    // Update or add images
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
   * Store a newly created tutor
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(TutorStoreRequest $request)
  {
    // Create user
    $pw   = Str::random(16);
    $user = User::create([
      'email' => $request->input('email'),
      'email_verified_at' => \Carbon\Carbon::now(),
      'password' => Hash::make($pw),
      'role' => 'tutor'
    ]);

    $tutor = Tutor::create(array_merge($request->except('email'), ['user_id' => $user->id]));
    $tutor->save();

    // Add image
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

    $subscriber = $this->createSubscriber->execute([
      'mailinglist' => Mailinglist::find(env('MAILINGLIST_NEWSLETTER')),
      'email' => $request->input('email')
    ], TRUE);

    // Fire registered event
    event(new TutorStored($user, ['password' => $pw]));

    return response()->json(['tutorId' => $tutor->id]);
  }

  /**
   * Toggle the status a given tutor
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
   * Remove a tutor
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
   * Get course events for given tutor or an authenticated tutor with constraints
   *
   * @param String $type
   * @param Tutor $tutor
   * @return \Illuminate\Http\Response
   */

  public function getEvents($type = NULL, Tutor $tutor)
  {
    // Get tutor by logged in user
    $tutor = auth()->user()->isAdmin()
              ? $this->tutor->with('user')->findOrFail($tutor->id)
              : $this->tutor->with('user')->authenticated(auth()->user()->id);

    // Get events by type
    switch($type)
    {
      // Upcoming events
      case 'upcoming':
        $courseEvents = $tutor->courseEventDates('upcoming')
                              ->with('courseEvent.course', 'courseEvent.location')
                              ->get();
      break;

      // Past events
      case 'past':
        $courseEvents = $tutor->courseEventDates('past')
                              ->with('courseEvent.course', 'courseEvent.location')
                              ->get();
      break;

      // All events
      default:
        $courseEvents = $tutor->courseEventDates()
                              ->with('courseEvent.course', 'courseEvent.location')
                              ->get();
      break;
    }

    return response()->json(['tutor' => $tutor, 'courseEvents' => $courseEvents]);
  }

  /**
   * Get a course event for a given tutor or an authenticated tutor
   *
   * @param CourseEvent $courseEvent
   * @param Tutor $tutor
   * @return \Illuminate\Http\Response
   */
  public function getEvent(CourseEvent $courseEvent, Tutor $tutor)
  { 
    // Get tutor by logged in user
    $tutor = auth()->user()->isAdmin()
              ? $this->tutor->with('user')->findOrFail($tutor->id)
              : $this->tutor->with('user')->authenticated(auth()->user()->id);

    // Get courseEvent with all related data
    $courseEvent = $tutor->courseEventDates()
                         ->with('courseEvent.course', 'courseEvent.location', 'courseEvent.dates.tutor', 'courseEvent.documents', 'courseEvent.students')
                         ->where('course_event_id', '=', $courseEvent->id)
                         ->get()
                         ->first();

    return response()->json($courseEvent);
  }
}
