<?php
namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use App\Models\Tutor;
use App\Models\TutorImage;
use Illuminate\Http\Request;

class AboutController extends BaseController
{
  protected $viewPath = 'web.pages.about.';

  /**
   * Constructor
   * 
   */
  public function __construct(Tutor $tutor, TutorImage $tutorImage)
  {
    parent::__construct();
    $this->tutor      = $tutor;
    $this->tutorImage = $tutorImage;
  }


  /**
   * Show the about page
   *
   * @return \Illuminate\Http\Response
   */

  public function about()
  { 
    return view($this->viewPath . 'about');
  }

  /**
   * Show the tutors page
   *
   * @return \Illuminate\Http\Response
   */

  public function tutors()
  {
    return 
      view($this->viewPath . 'tutors', 
        [
          'leaders' => $this->tutor->leader()->get(),
          'tutors' => $this->tutor->active()->where('is_leader', '=', 0)->get(),
        ]
      );
  }

  /**
   * Show a single tutors profil by given tutor
   *
   * @param String $slug
   * @param Tutor $tutor
   * @return \Illuminate\Http\Response
   */

  public function tutor($slug = NULL, Tutor $tutor)
  {
    return 
      view($this->viewPath . 'tutor', 
        [
          'tutor'   => $this->tutor->with('images')->findOrFail($tutor->id),
          'leaders' => $this->tutor->leader()->get(),
          'tutors'  => $this->tutor->active()->where('is_leader', '=', 0)->get(),
        ]
      );
  }
}
