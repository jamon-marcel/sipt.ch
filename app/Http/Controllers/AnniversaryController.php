<?php
namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class AnniversaryController extends BaseController
{
  protected $viewPath = 'web.pages.anniversary.';

  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Show the anniversary page
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view($this->viewPath . 'index');
  }

  /**
   * Show the thank you page
   *
   * @return \Illuminate\Http\Response
   */
  public function registered()
  {
    return view($this->viewPath . 'confirmation');
  }
}
