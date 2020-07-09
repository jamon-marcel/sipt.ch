<?php
namespace App\View\Components;
use Illuminate\View\Component;

class Quote extends Component
{

  /**
   * Quote
   *
   * @var string
   */
  public $quote;

  /**
   * Author
   *
   * @var string
   */
  public $author;

  /**
   * Size
   *
   * @var string
   */
  public $size;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($quote = NULL, $author = NULL, $size = NULL)
  {
    $this->quote  = $quote;
    $this->author = $author;
    $this->size   = $size;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|string
   */
  public function render()
  {
    return view('web.components.content.quote');
  }
}
