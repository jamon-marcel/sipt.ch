<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\Location;
use App\Http\Requests\LocationStoreRequest;
use Illuminate\Http\Request;

class LocationController extends Controller
{

  public function __construct(Location $location)
  {
    $this->location = $location;
  }

  /**
   * Get a list of locations
   * 
   * @return \Illuminate\Http\Response
   */
  public function get()
  {
    return new DataCollection($this->location->get());
  }

  /**
   * Get a single location for a given location
   * 
   * @param Location $location
   * @return \Illuminate\Http\Response
   */
  public function find(Location $location)
  {
    return response()->json($this->location->findOrFail($location->id));
  }

  /**
   * Store a newly created location
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(LocationStoreRequest $request)
  {
    $location = Location::create($request->except('maps_file'));
    $location->save();

    if ($request->input('maps_file') && !empty($request->input('maps_file')))
    {
      $file = $request->input('maps_file');
      $location->maps_file = isset($file[0]['name']) ? $file[0]['name'] : null;
      $location->save();
    }

    return response()->json(['locationId' => $location->id]);
  }

  /**
   * Update the current location
   *
   * @param Location $location
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function update(Location $location, LocationStoreRequest $request)
  {
    $location->update($request->except('maps_file'));
    $location->maps_file = null;
    
    if ($request->input('maps_file') && !empty($request->input('maps_file')))
    {
      $file = $request->input('maps_file');
      $location->maps_file = isset($file[0]['name']) ? $file[0]['name'] : null;
    }

    $location->save();
    return response()->json('successfully updated');
  }

  /**
   * Toggle the status of the specified resource.
   *
   * @param  Location $location
   * @return \Illuminate\Http\Response
   */
  public function toggle(Location $location)
  {
    $location->is_published = $location->is_published == 0 ? 1 : 0;
    $location->save();
    return response()->json($location->is_published);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  Location $location
   * @return \Illuminate\Http\Response
   */
  public function destroy(Location $location)
  {
    $location->delete();
    return response()->json('successfully deleted');
  }
}