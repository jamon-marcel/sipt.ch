<?php
namespace App\Http\Controllers\Api;
use App\Models\CourseEventFile;
use App\Models\Tutor;
use App\Http\Requests\CourseEventFileStoreRequest;
use App\Http\Resources\DataCollection;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseEventFileController extends Controller
{
  protected $courseEventFile;
  protected $tutor;
  
  /**
   * Constructor
   * 
   * @param CourseEventFile $courseEventFile
   */

  public function __construct(CourseEventFile $courseEventFile, Tutor $tutor)
  {
    $this->courseEventFile = $courseEventFile;
    $this->tutor = $tutor;
  }

  /**
   * Store uploaded files
   *
   * @param  CourseEventFileStoreRequest $request
   * @return \Illuminate\Http\Response
   */
  public function store(CourseEventFileStoreRequest $request)
  {
    if (auth()->user()->isTutor())
    {
      $tutor = $this->tutor->with('user')->authenticated(auth()->user()->id);
    }

    if (!empty($request->documents))
    {
      foreach($request->documents as $i)
      {
        $file = new CourseEventFile([
          'name'     => $i['name'],
          'caption'  => !empty($i['caption']) ? $i['caption'] : $i['name'],
          'size'     => $i['size'],
          'type'     => $i['type'],
          'tutor_id' => isset($tutor) ? $tutor->id : NULL,
          'course_event_id' => $i['course_event_id'],
        ]);
        $file->save();
      }
    }

    return response()->json('successfully updated');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  string $file
   * @return \Illuminate\Http\Response
   */
  
  public function destroy($file)
  {
    // Delete image from database
    $record = $this->courseEventFile->where('name', '=', $file)->first();
    
    if ($record)
    {
      $record->delete();
    }

    // Delete file from storage
    $directories = Storage::allDirectories('public');
    foreach($directories as $d)
    {
      Storage::delete($d . '/'. $file);
    }
    return response()->json('successfully deleted');
  }

}
