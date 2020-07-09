<?php
namespace App\Http\Controllers;
namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
  protected $viewPath = 'web.pages.home.index';

  public function __construct()
  {
    parent::__construct();
  }

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



  // public function pdf()
  // {
  //   $this->viewData['subscriber'] = [];
  //   $pdf  = PDF::loadView('pdf.invoice', $this->viewData);

  //   // Set path & filename
  //   $path = public_path() . '/storage/downloads/';
  //   $file = 'sipt_rechnung-' . date('d.m.Y-H.i.s', time()) . '.pdf';

  //   // Store file
  //   $pdf->save($path . '/' . $file);
  // }
}
