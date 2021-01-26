<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\VipAddress;
use App\Models\Student;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Http\Request;

class SearchAddressController extends Controller
{
  public function __construct(VipAddress $vipAddress, Student $student, Tutor $tutor)
  {
    $this->vipAddress        = $vipAddress;
    $this->student    = $student;
    $this->tutor      = $tutor;
  }

  public function search(Request $request)
  {
    $results = [
      'students' => [],
      'tutors' => [],
      'vip' => []
    ];
    
    // Students
    $students = $this->student->with('user')->where('name', 'like', '%' . $request->input('keyword') . '%')->get();
    if ($students)
    {
      $results['students'] = $students;
    }

    // Tutors
    $tutors = $this->tutor->with('user')->where('name', 'like', '%' . $request->input('keyword') . '%')->get();
    if ($tutors)
    {
      $results['tutors'] = $tutors;
    }

    // VIP
    $vip = $this->vipAddress->where('name', 'like', '%' . $request->input('keyword') . '%')->get();
    if ($vip)
    {
      $results['vip'] = $vip;
    }
    return response()->json($results);
  }
}
