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
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($mailinglists = NULL)
  {
    $this->mailinglists = MailinglistModel::orderBy('order')->get();
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
