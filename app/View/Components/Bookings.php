<?php
namespace App\View\Components;
use Illuminate\View\Component;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;

class Bookings extends Component
{

  /**
   * Bookings
   *
   * @var array
   */
  public $bookings;

  /**
   * Student
   *
   * @var \App\Models\Student
   */
  public $student;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct(Request $request, Student $student)
  {
    $this->bookings = $request->session()->has('bookings') ? $request->session()->get('bookings') : [];
    $this->student  = auth()->user() && auth()->user()->role == 'student' ? $student->with('user')->authenticated(auth()->user()->id) : false;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|string
   */
  public function render()
  {
    return view('web.components.content.bookings');
  }
}
