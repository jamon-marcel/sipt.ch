<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class SymposiumController extends Controller
{
  protected $viewPath = 'web.pages.symposium.';

  /**
   * Show the homepage
   *
   * @return \Illuminate\Http\Response
   */

  public function anniversary()
  { 
    return view($this->viewPath . 'anniversary', ['sidebar' => 'form']);
  }

  /**
   * Show the thank you page
   *
   * @return \Illuminate\Http\Response
   */

  public function registered()
  {
    return view($this->viewPath . 'anniversary', ['sidebar' => 'confirmation']);
  }

}
