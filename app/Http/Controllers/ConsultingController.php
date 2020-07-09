<?php
namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class ConsultingController extends BaseController
{
  protected $viewPath = 'web.pages.consulting.index';

  public function __construct()
  {
    parent::__construct();
  }

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
