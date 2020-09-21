<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\Message;
use App\Models\MessageLog;
use App\Models\CourseEvent;
use App\Models\Tutor;
use App\Models\Administrator;
use App\Http\Requests\MessageStoreRequest;
use Illuminate\Http\Request;

class MessageController extends Controller
{

  public function __construct(Message $message, CourseEvent $courseEvent, Tutor $tutor, Administrator $administrator)
  {
    $this->message = $message;
    $this->courseEvent = $courseEvent;
    $this->tutor = $tutor;
    $this->administrator = $administrator;
  }

  /**
   * Get a list of courses
   *
   * @param CourseEvent $courseEvent
   * @return \Illuminate\Http\Response
   */
  public function get(CourseEvent $courseEvent)
  {
    $messages = $this->message->with('event')->where('course_event_id', '=', $courseEvent->id)->orderBy('date')->get();
    return response()->json($messages);
  }

  /**
   * Get a single course for a given message
   *
   * @param Message $message
   * @return \Illuminate\Http\Response
   */
  public function find(Message $message)
  {
    $message = $this->message->find($message->id);
    return response()->json($message);
  }

  /**
   * Store a newly created message
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(MessageStoreRequest $request)
  {
    // Get sender from authenticated user
    $sender = auth()->user()->isAdmin()
            ? $this->administrator->with('user')->where('user_id', '=', auth()->user()->id)->get()->first()
            : $this->tutor->with('user')->authenticated(auth()->user()->id);

    $data = [
      'date' => date('d.m.Y', time()),
      'course_event_id' => $request->input('course_event_id'),
      'subject' => $request->input('subject'),
      'message' => $request->input('message'),
      'senderName' => $sender->fullName,
      'senderEmail' => $sender->user->email,
    ];

    $message = Message::create($data);
    $message->save();

    // Add admin to message queue
    MessageLog::create([
      'email' => 'r.barwinski@swissonline.ch',
      'message_id' => $message->id
    ]);    

    // Add sender to message queue
    MessageLog::create([
      'email' => $sender->user->email,
      'message_id' => $message->id
    ]);    

    // Get students & add the to the message Queue
    $courseEvent = $this->courseEvent->with('students.user')->findOrFail($request->input('course_event_id'));

    foreach($courseEvent->students as $student)
    {
      MessageLog::create([
        'email' => $student->user->email,
        'student_id' => $student->id,
        'message_id' => $message->id
      ]);
    }

    return response()->json(['messageId' => $message->id]);
  }
}
