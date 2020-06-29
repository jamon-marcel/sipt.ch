<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
  /**
   * Name
   *
   * @var string
   */
  public $name;

  /**
   * Label
   *
   * @var string
   */
  public $label;

  /**
   * Class
   *
   * @var string
   */
  public $class;

  /**
   * Type
   *
   * @var string
   */
  public $type;

  /**
   * Create a new component instance.
   *
   * @param $name
   * @param $label
   * @param $class
   * @param $type
   * @return void
   */
  public function __construct($name, $label, $class = '', $type = 'submit')
  {
    $this->name = $name;
    $this->label = $label;
    $this->class = $class;
    $this->type = $type;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|string
   */
  public function render()
  {
    return view('web.components.form.button');
  }
}
