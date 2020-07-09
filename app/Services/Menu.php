<?php
namespace App\Services;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class Menu
{
  // Menu item active class
  protected $active = 'is-active';

  public function __construct()
  {
    $training = new \App\Models\Training;
    $this->training = $training;
  }

  public function boot()
  {
    $trainings = $this->training->with('category', 'courses')->get();
    $data = [];

    foreach($trainings as $t)
    {
      if ($t->courses)
      {
        $data[$t->category->id] = [
          'id'       => $t->category->id,
          'category' => $t->category->id,
          'label'    => $t->category->name_short,
          'order'    => $t->category->order,
          'slug'     => \AppHelper::slug($t->category->name_short)
        ];
      }
    }

    $data = collect($data)->sortBy('order');
    View::share('menuItems', $data);
  }
}