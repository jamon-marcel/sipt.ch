<?php
namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use App\Models\PartnerInstitution;
use App\Models\Therapist;
use App\Models\TherapistIntro;
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
    $intro = TherapistIntro::first();
    $germanyTherapists = Therapist::active()->byCountry('Germany')->orderBy('order')->get();
    $switzerlandTherapists = Therapist::active()->byCountry('Switzerland')->orderBy('order')->get();

    return view($this->viewPath . 'therapists', compact('intro', 'germanyTherapists', 'switzerlandTherapists'));
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
