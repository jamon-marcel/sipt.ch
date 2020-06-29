<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use PDF;
use Illuminate\Support\Facades\Storage;

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

  public function pdf()
  {
    $this->viewData['subscriber'] = [];
    $pdf  = PDF::loadView('pdf.invoice', $this->viewData);

    // Set path & filename
    $path = public_path() . '/storage/downloads/';
    $file = 'sipt_rechnung-' . date('d.m.Y-H.i.s', time()) . '.pdf';

    // Store file
    $pdf->save($path . '/' . $file);
  }
}
