<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\Location;
use App\Models\TrainingCategory;
use App\Models\CourseSpecialization;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
  public function __construct(Location $location, TrainingCategory $trainingCategory, CourseSpecialization $courseSpecialization)
  {
    $this->location = $location; 
    $this->trainingCategory = $trainingCategory;
    $this->courseSpecialization = $courseSpecialization;
  }

  public function locations()
  {
    return new DataCollection($this->location->get());
  }

  public function trainingCategories()
  {
    return new DataCollection($this->trainingCategory->orderBy('name')->get());
  }

  public function courseSpecializations()
  {
    return new DataCollection($this->courseSpecialization->get());
  }

}
