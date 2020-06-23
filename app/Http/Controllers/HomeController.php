<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  protected $viewPath = 'web.pages.home.index';

  /**
   * Show the homepage
   *
   * @return \Illuminate\Http\Response
   */

  public function index()
  { 
    return view($this->viewPath);
  }

  public function login()
  {
    return view('auth.login');
  }
}
