<?php
namespace App\Http\Controllers\Api;
use App\Models\TutorImage;
use App\Http\Resources\DataCollection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TutorImageController extends Controller
{
  protected $tutorImage;
  
  /**
   * Constructor
   * 
   * @param TutorImage $tutorImage
   */

  public function __construct(TutorImage $tutorImage)
  {
    $this->tutorImage = $tutorImage;
  }

  /**
   * Update the status of the specified resource.
   *
   * @param  int $id
   * @return \Illuminate\Http\Response
   */
  public function status($id)
  {
    $tutorImage = $this->tutorImage->findOrFail($id);
    $tutorImage->publish = $tutorImage->publish == 0 ? 1 : 0;
    $tutorImage->save();
    return response()->json($tutorImage->publish);
  }

  /**
   * Update the cropping coords of the specified resource.
   *
   * @param TutorImage $tutorImage
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function coords(TutorImage $tutorImage, Request $request)
  {
    $image = $this->tutorImage->findOrFail($tutorImage->id);
    $image->coords_w = round($request->input('coords_w'), 12);
    $image->coords_h = round($request->input('coords_h'), 12);
    $image->coords_x = round($request->input('coords_x'), 12);
    $image->coords_y = round($request->input('coords_y'), 12);
    $image->save();
    $this->removeCachedImage($image);
    return response()->json('successfully updated');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  string $image
   * @return \Illuminate\Http\Response
   */
  
  public function destroy($image)
  {
    // Delete image from database
    $record = $this->tutorImage->where('name', '=', $image)->first();
    
    if ($record)
    {
      $record->delete();
    }

    // Delete file from storage
    $directories = Storage::allDirectories('public');
    foreach($directories as $d)
    {
      Storage::delete($d . '/'. $image);
    }
    
    return response()->json('successfully deleted');
  }

  /**
   * Remove cached version of the image
   *
   * @param TutorImage $tutorImage
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  private function removeCachedImage(TutorImage $tutorImage)
  {
    // Get an instance of the ImageCache class
    $imageCache = new \Intervention\Image\ImageCache();

    // Get a cached image from it and apply all of your templates / methods
    $image = $imageCache->make(storage_path('app/public/uploads/') . $tutorImage->name)->filter(new \App\Filters\Image\Template\Portrait);

    // Remove the image from the cache by using its internal checksum
    Cache::forget($image->checksum());
  }
}
