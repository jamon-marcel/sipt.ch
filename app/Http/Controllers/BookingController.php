<?php
namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use App\Models\CourseEvent;
use App\Models\CourseEventStudent;
use App\Http\Requests\StudentRegisterRequest;
use App\Services\Withdrawal;
use App\Events\StudentRegistered;
use App\Events\CourseEventBooked;
use App\Events\CourseEventCancelled;
use App\Events\CourseEventCancelledWithPenalty;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class BookingController extends BaseController
{

  public function __construct(
    Course $course, 
    CourseEvent $courseEvent, 
    CourseEventStudent $courseEventStudent, 
    Student $student
  )
  {
    parent::__construct();
    $this->course = $course;
    $this->courseEvent = $courseEvent;
    $this->courseEventStudent = $courseEventStudent;
    $this->student = $student;
  }

  /**
   * Add a course event to the users session
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

  public function remove(Request $request, CourseEvent $courseEvent)
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

  /**
   * Register a user and store a course events
   *
   * @param StudentRegisterRequest $request
   * @return \Illuminate\Http\Response
   */
  public function registerAndStore(StudentRegisterRequest $request)
  { 
    // Create user
    $pw   = Str::random(16);
    $user = User::create([
      'email' => $request->input('email'),
      'password' => Hash::make($pw),
      'role' => 'student'
    ]);

    // Create Student
    $student_number = Student::max('number') + 1;
    $student = Student::create(array_merge($request->except('email'), ['user_id' => $user->id, 'number' => $student_number]));

    // Get the student
    $student = $this->student->with('user')->find($student->id);

    // Fire registered event
    event(new StudentRegistered($user, ['password' => $pw]));

    // Create Bookings
    if ($request->session()->has('bookings'))
    {
      $bookings = $request->session()->get('bookings');
      foreach($bookings as $booking)
      {
        // Create booking number
        $booking_number = CourseEventStudent::withTrashed()->max('booking_number') + 1;
        
        // Create course
        $course_event = CourseEventStudent::updateOrCreate([
          'course_event_id' => $booking['id'],
          'student_id' => $student->id,
          'booking_number' => $booking_number
        ]);

        // Get course event data
        $courseEvent = $this->courseEvent->with('course', 'dates')->find($booking['id']);

        // Confirm booking
        event(new CourseEventBooked($student, $courseEvent));
      }

      // Remove bookings
      $request->session()->forget('bookings');
    }

    return response()->json(true);
  }

  /**
   * Store course events for authenticated user
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $student = $this->student->with('user')->authenticated(auth()->user()->id);

    // Create Bookings
    if ($request->session()->has('bookings'))
    {
      $bookings = $request->session()->get('bookings');
      foreach($bookings as $booking)
      {
        // Create booking number
        $max_booking_number = CourseEventStudent::withTrashed()->max('booking_number') + 1;
        $booking_number     = ($max_booking_number > \Config::get('sipt.min_booking_number')) ? $max_booking_number : \Config::get('sipt.min_booking_number');

        // Create course
        $course_event = CourseEventStudent::updateOrCreate([
          'course_event_id' => $booking['id'],
          'student_id' => $student->id,
          'booking_number' => str_pad($booking_number, 6, "0", STR_PAD_LEFT)
        ]);

        // Get course event data
        $courseEvent = $this->courseEvent->with('course', 'dates')->find($booking['id']);

        // Confirm booking
        event(new CourseEventBooked($student, $courseEvent));
      }

      // Remove bookings
      $request->session()->forget('bookings');
    }

    return response()->json(true);
  }

  /**
   * Show cancel preview for a course event by given courseEvent and student
   * 
   * @param CourseEvent $courseEvent
   * @param Student $student
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function cancel(CourseEvent $courseEvent, Student $student)
  {
    $record = $this->courseEventStudent->where('course_event_id', '=', $courseEvent->id)
                                       ->where('student_id', '=', $student->id)
                                       ->firstOrFail();

    $courseEvent = $this->courseEvent->with('course', 'dates')->findOrFail($courseEvent->id);

    // Get withdrawal penalty
    $withdrawal = new Withdrawal();
    $penalty    = $withdrawal->getCharges($courseEvent->dateStart);
    
    return 
      view('web.pages.course.cancel-preview', 
        [
          'courseEvent' => $courseEvent,
          'id' => $record->id,
          'penalty' => $penalty
        ]
      );
  }

  /**
   * Delete a booking by given id
   * 
   * @param  CourseEventStudentDestroyRequest $request
   * @return \Illuminate\Http\Response
   */

  public function destroy(Request $request)
  {
    $courseEventStudent = $this->courseEventStudent->findOrFail($request->input('id'));
    $courseEvent = $this->courseEvent->with('course', 'dates')->findOrFail($courseEventStudent->course_event_id);
    $student = $this->student->findOrFail($courseEventStudent->student_id);

    // Get withdrawal penalty
    $withdrawal = new Withdrawal();
    $penalty    = $withdrawal->getCharges($courseEvent->dateStart);

    // If there is no penalty set cancellation date and delete entry
    if ($penalty == 0)
    {
      // Confirm cancellation
      event(new CourseEventCancelled($student, $courseEventStudent, $courseEvent));
    }
    else
    {
      // Confirm cancellation
      event(new CourseEventCancelledWithPenalty($student, $courseEventStudent, $courseEvent, $penalty));
    }

    return view('web.pages.course.cancel-confirm');
  }

}
