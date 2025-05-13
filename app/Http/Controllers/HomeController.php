<?php
namespace App\Http\Controllers;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\NewsArticle;
use App\Models\NewsCategory;

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

    $news = NewsCategory::active()
      ->whereHas('publishedArticles') // only categories with published articles
      ->with(['publishedArticles' => function ($query) {
        $query->orderBy('order');
      }])
      ->orderBy('order')
      ->get();
    return view($this->viewPath, compact('news'));
  }

  public function login()
  {
    return view('auth.login');
  }
}
