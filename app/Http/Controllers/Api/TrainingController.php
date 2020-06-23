<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\Training;
use App\Models\CourseTraining;
use App\Http\Requests\TrainingStoreRequest;
use Illuminate\Http\Request;

class TrainingController extends Controller
{

  public function __construct(Training $training)
  {
    $this->training = $training;
  }

  /**
   * Get a list of trainings
   * 
   * @return \Illuminate\Http\Response
   */
  public function get()
  {
    return new DataCollection($this->training->with('category')->get());
  }

  /**
   * Get a single training for a given training
   * 
   * @param Training $training
   * @return \Illuminate\Http\Response
   */
  public function find(Training $training)
  {
    return response()->json($this->training->with('category', 'location', 'courses')->findOrFail($training->id));
  }

  /**
   * Store a newly created training
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(TrainingStoreRequest $request)
  {
    $training = Training::create($request->except('courses'));
    $training->save();

    // Course Training
    if (!empty($request->courses))
    {
      foreach($request->courses as $course)
      {
        $course_training = new CourseTraining([
          'course_id' => $course['id'],
          'training_id' => $training->id
        ]);
        $course_training->save();
      }
    }

    return response()->json(['trainingId' => $training->id]);
  }

  /**
   * Update the current training
   *
   * @param Training $training
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function update(Training $training, TrainingStoreRequest $request)
  {
    $training->update($request->all());
    $training->save();

    if ($request->courses)
    {
      $training->courses()->detach();
      foreach($request->courses as $course)
      { 
        $course_training = new CourseTraining([
          'course_id' => $course['id'],
          'training_id' => $training->id
        ]);
        $course_training->save();
      }
    }    

    return response()->json('successfully updated');
  }

  /**
   * Toggle the status of the specified resource.
   *
   * @param  Training $training
   * @return \Illuminate\Http\Response
   */
  public function toggle(Training $training)
  {
    $training->is_published = $training->is_published == 0 ? 1 : 0;
    $training->save();
    return response()->json($training->is_published);
  }

  /**
   * Remove the specified resource from storage.
   *
   * \Observers\TrainingObserver observes and deletes child elements.
   * @param  Training $training
   * @return \Illuminate\Http\Response
   */
  public function destroy(Training $training)
  {
    $training->delete();
    return response()->json('successfully deleted');
  }
}