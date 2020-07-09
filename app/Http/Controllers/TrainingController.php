<?php
namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use App\Models\Training;
use App\Models\TrainingCategory;
use Illuminate\Http\Request;

class TrainingController extends BaseController
{
  protected $viewPath = 'web.pages.training.';

  protected $training;

  public function __construct(Training $training, TrainingCategory $trainingCategory)
  {
    parent::__construct();
    $this->training = $training;
    $this->trainingCategory = $trainingCategory;
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
          'activeCategory' => $trainingCategory->id
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
    $training = $this->training->with('courses')->findOrFail($training->id);
    return 
      view($this->viewPath . 'show', 
        [
          'training' => $training,
          'activeCategory' => $training->category_id
        ]
      );
  }

}
