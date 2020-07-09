<?php
namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class SymposiumController extends BaseController
{
  protected $viewPath = 'web.pages.symposium.';

  public function __construct()
  {
    parent::__construct();
  }

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
