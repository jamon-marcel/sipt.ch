<?php
namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use App\Models\Training;
use App\Models\TrainingCategory;
use App\Models\Specialisation;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class TrainingController extends BaseController
{
  protected $viewPath = 'web.pages.training.';

  protected $training;

  public function __construct(Training $training, TrainingCategory $trainingCategory, Specialisation $specialisation)
  {
    parent::__construct();
    $this->training = $training;
    $this->trainingCategory = $trainingCategory;
    $this->specialisation = $specialisation;
  }

  /**
   * List trainings by given category
   *
   * @param String $slug
   * @param TrainingCategory $trainingCategory
   * @return \Illuminate\Http\Response
   */

  public function trainingsByCategory($slug = NULL, TrainingCategory $trainingCategory)
  { 
    $trainings = $this->training->where('category_id', '=', $trainingCategory->id)->get();
    $trainingCategory = $this->trainingCategory->find($trainingCategory->id);

    return 
      view($this->viewPath . 'listing', 
        [
          'category'  => $trainingCategory,
          'trainings' => $trainings,
          'activeCategory' => $trainingCategory->id,
          'quote' => \Config::get('sipt.quotes.' . $trainingCategory->id),
        ]
      );
  }

  /**
   * Show a training by given training
   *
   * @param String $slug
   * @param Training $training
   * @return \Illuminate\Http\Response
   */

  public function show($slug = NULL, Training $training)
  { 
    $training = $this->training->with('courses.specialisations', 'courses.eventsUpcoming.dates.tutor')->findOrFail($training->id);
    $specialisations = $this->specialisation->with('courses')->get();

    /*
    if (auth()->user()->isAdmin())
    {
      // Create pdf
      $data = [];

      foreach($training->courses as $course)
      {
        if ($course->eventsUpcoming)
        {
          foreach($course->eventsUpcoming as $event)
          {
            $data[] = $event;
          }
        }
      }

      $this->viewData['data'] = $data;
      $pdf = PDF::loadView('pdf.lists.courses', $this->viewData);

      // Set path & filename
      $path = public_path() . '/storage/temp/';
      $filename = 'sipt.ch-modulliste-' . date('dmY', time()) . '-' . \Str::random(8);
      $file = $filename . '.pdf';
      return $pdf->download($file);
    }
    */

    return 
      view($this->viewPath . 'show', 
        [
          'training' => $training,
          'hasSpecialisations' => \Config::get('sipt.cas_consultant_psychotraumatology_id') == $training->id ? TRUE : FALSE,
          'specialisations' => $specialisations,
          'activeCategory' => $training->category_id
        ]
      );
  }

  /**
   * Export all courseEvents for a training by given training
   *
   * @param String $slug
   * @param Training $training
   * @return \Illuminate\Http\Response
   */

  public function export($slug = NULL, Training $training)
  { 
    $training = $this->training->with('courses.specialisations', 'courses.eventsUpcoming.dates.tutor')->findOrFail($training->id);
    $specialisations = $this->specialisation->with('courses')->get();

    $data = [];
    foreach($training->courses as $course)
    {
      if ($course->eventsUpcoming)
      {
        foreach($course->eventsUpcoming as $event)
        {
          $data[] = $event;
        }
      }
    }

    $this->viewData['data_title'] = $training->title;
    $this->viewData['data'] = collect($data)->sortBy('dateStartTimestamp');
    $pdf = PDF::loadView('pdf.lists.courses-export', $this->viewData);

    // Set path & filename
    $path = public_path() . '/storage/temp/';
    $filename = 'sipt.ch-modulliste-' . $slug . '-' . date('dmY', time()) . '-' . \Str::random(8);
    $file = $filename . '.pdf';
    return $pdf->download($file);    
  }
}
