<?php
namespace App\Filters\Image\Template;
use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;
use App\Models\ProjectImage;

class Cache implements FilterInterface
{
  protected $max_width  = 2000;    
  protected $max_height = 1250;

  protected $size = null;

  public function __construct($size)
  {
    $this->size = $size;
  }

  public function applyFilter(Image $image)
  {
    // $this->image = new \App\Models\ProjectImage;
    // $img = $this->image->where('name', '=', $image->basename)->get()->first();
    
    // // Crop the image if coords are set
    // if ($img && $img->coords_w && $img->coords_h)
    // {
    //   return 
    //     $image->crop(floor($img->coords_w), floor($img->coords_h), floor($img->coords_x), floor($img->coords_y))
    //           ->resize($this->max_width, null, function ($constraint) {
    //             $constraint->aspectRatio();
    //             $constraint->upsize();
    //           });
    // }

    // Otherwise just resize the image
    $width  = $image->getWidth();
    $height = $image->getHeight();

    // Resize landscape image
    if ($width > $height && $width >= $this->max_width)
    {
      $image->resize($this->size, null, function ($constraint) {
        return $constraint->aspectRatio();
      });
    }
    else if ($height >= $this->max_height)
    {
      $image->resize(null, $this->size, function ($constraint) {
        return $constraint->aspectRatio();
      });
    }
    return $image;
  }
}