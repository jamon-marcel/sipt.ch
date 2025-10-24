<?php
namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use App\Models\PartnerInstitution;
use Illuminate\Http\Request;

class NetworkController extends BaseController
{
  protected $viewPath = 'web.pages.network.';

  public function __construct()
  {
    parent::__construct();
  }

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
   * Show the partner institutions page
   *
   * @return \Illuminate\Http\Response
   */

  public function partners()
  {
    $partners = PartnerInstitution::active()->ordered()->get();
    return view($this->viewPath . 'partners', compact('partners'));
  }
}
