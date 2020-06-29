<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ConsultingController extends Controller
{
  protected $viewPath = 'web.pages.consulting.index';

  /**
   * Show the consulting index page
   *
   * @return \Illuminate\Http\Response
   */

  public function index()
  { 
    return view($this->viewPath);
  }
}
