<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\TutorStoreRequest;
use Illuminate\Http\Request;

class TutorController extends Controller
{
  public function __construct(Tutor $tutor)
  {
    $this->tutor = $tutor;
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
    return response()->json($this->tutor->with('user')->find($tutor->id));
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
    $tutor->update($request->except('user.email'));
    $tutor->save();
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
}
