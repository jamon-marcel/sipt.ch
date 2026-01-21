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
   * Css
   *
   * @var string
   */
  public $css;

  /**
   * Autocomplete
   *
   * @var boolean
   */
  public $autocomplete;

  /**
   * Value
   *
   * @var string
   */
  public $value;

  /**
   * Show Required (asterisk only, no validation)
   *
   * @var boolean
   */
  public $showRequired;

  /**
   * Create a new component instance.
   *
   * @param $name
   * @param $type
   * @param $label
   * @param $placeholder
   * @param $required
   * @param $css
   * @param $autocomplete
   * @param $value
   * @param $showRequired
   * 
   * @return void
   */
  public function __construct($name, $type = 'text', $label = NULL, $placeholder = NULL, $required = FALSE, $css = NULL, $autocomplete = TRUE, $value = NULL, $showRequired = FALSE)
  {
    $this->name = $name;
    $this->type = $type;
    $this->label = $label;
    $this->placeholder = $placeholder;
    $this->required = $required;
    $this->css = $css;
    $this->autocomplete = $autocomplete;
    $this->value = $value;
    $this->showRequired = $showRequired;
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
