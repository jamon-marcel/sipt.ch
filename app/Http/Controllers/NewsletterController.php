<?php
namespace App\Http\Controllers;
use App\Models\NewsletterSubscriber;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class NewsletterController extends BaseController
{
  protected $viewPath = 'web.pages.newsletter.';

  public function __construct(NewsletterSubscriber $newsletterSubscriber)
  {
    parent::__construct();
    $this->newsletterSubscriber = $newsletterSubscriber;
  }

  /**
   * Show the newsletter cancelled page
   *
   * @param NewsletterSubscriber $newsletterSubscriber
   * @return \Illuminate\Http\Response
   */

  public function cancel(NewsletterSubscriber $newsletterSubscriber)
  { 
    $newsletterSubscriber = $this->newsletterSubscriber->findOrFail($newsletterSubscriber->id);
    $newsletterSubscriber->delete();
    return view($this->viewPath . 'cancel');
  }
}
