<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\Training;
use App\Http\Requests\TrainingStoreRequest;
use Illuminate\Http\Request;

class TrainingController extends Controller
{

  public function __construct(Training $training)
  {
    $this->training = $training;
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return new DataCollection($this->training->get());
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(TrainingStoreRequest $request)
  {
    $training = Training::create($request->all());
    $training->save();
    return response()->json(['trainingId' => $training->id]);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param Training $training
   * @return \Illuminate\Http\Response
   */
  public function edit(Training $training)
  {
    return response()->json($this->training->find($training->id));
  }

  /**
   * Update the current student
   *
   * @param Training $training
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function update(Training $training, TrainingStoreRequest $request)
  {
    $training->update($request->all());
    $training->save();
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
   * @param  Training $training
   * @return \Illuminate\Http\Response
   */
  public function destroy(Training $training)
  {
    $training->delete();
    return response()->json('successfully deleted');
  }
}
