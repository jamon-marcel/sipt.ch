<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TextField extends Component
{

  /**
   * Name
   *
   * @var string
   */
  public $name;

  /**
   * Type
   *
   * @var string
   */
  public $type;

  /**
   * Label
   *
   * @var string
   */
  public $label;

  /**
   * Placeholder
   *
   * @var string
   */
  public $placeholder;

  /**
   * Required
   *
   * @var string
   */
  public $required;

  /**
   * Create a new component instance.
   *
   * @param $name
   * @param $type
   * @param $label
   * @param $placeholder
   * @param $required
   * 
   * @return void
   */
  public function __construct($name, $type = 'text', $label, $placeholder = NULL, $required = FALSE)
  {
    $this->name = $name;
    $this->type = $type;
    $this->label = $label;
    $this->placeholder = $placeholder;
    $this->required = $required;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|string
   */
  public function render()
  {
    return view('web.components.form.text-field');
  }
}
