<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class NetworkController extends Controller
{
  protected $viewPath = 'web.pages.network.';

  /**
   * Show the therapists page
   *
   * @return \Illuminate\Http\Response
   */

  public function therapists()
  { 
    return view($this->viewPath . 'therapists');
  }

  /**
   * Show the therapists page
   *
   * @return \Illuminate\Http\Response
   */

  public function clinics()
  { 
    return view($this->viewPath . 'clinics');
  }

  /**
   * Show the therapists page
   *
   * @return \Illuminate\Http\Response
   */

  public function partners()
  { 
    return view($this->viewPath . 'partners');
  }
}
