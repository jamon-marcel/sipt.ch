<?php
namespace App\View\Components;
use Illuminate\View\Component;
use App\Models\Mailinglist as MailinglistModel;

class Mailinglists extends Component
{

  /**
   * Mailinglists
   *
   * @var array
   */
  public $mailinglists;

  /**
   * Subscriptions
   *
   * @var array
   */
  public $subscriptions;
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($mailinglists = NULL, $subscriptions = NULL)
  {
    $this->mailinglists = MailinglistModel::orderBy('order')->get();
    $this->subscriptions = $subscriptions;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|string
   */
  public function render()
  {
    return view('web.components.content.mailinglists');
  }
}
