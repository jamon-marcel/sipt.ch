<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\Location;
use App\Models\TrainingCategory;
use App\Models\Specialisation;
use App\Models\Mailinglist;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
  public function __construct(Location $location, TrainingCategory $trainingCategory, Specialisation $specialisation, Mailinglist $mailinglist)
  {
    $this->location = $location; 
    $this->trainingCategory = $trainingCategory;
    $this->specialisation = $specialisation;
    $this->mailinglist = $mailinglist;
  }

  public function locations()
  {
    return new DataCollection($this->location->get());
  }

  public function trainingCategories()
  {
    return new DataCollection($this->trainingCategory->orderBy('name')->get());
  }

  public function specialisations()
  {
    return new DataCollection($this->specialisation->get());
  }

  public function mailinglists()
  {
    return new DataCollection($this->mailinglist->orderBy('order')->get());
  }

}
