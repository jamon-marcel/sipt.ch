<?php
namespace App\View\Components;
use Illuminate\View\Component;
use Illuminate\Http\Request;

class MenuMeta extends Component
{

  /**
   * Count
   *
   * @var array
   */
  public $count;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct(Request $request)
  {
    $this->count = $request->session()->has('bookings') ? count($request->session()->get('bookings')) : 0;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|string
   */
  public function render()
  {
    return view('web.components.content.menu-meta');
  }
}
