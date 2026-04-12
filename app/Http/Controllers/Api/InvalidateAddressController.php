<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\VipAddress;
use App\Models\Student;
use App\Models\Tutor;
use Illuminate\Http\Request;

class InvalidateAddressController extends Controller
{
  public function invalidate(Request $request)
  {
    // Verify token
    $token = config('services.invalidate_address.token');
    if (!$token || $request->header('X-Api-Token') !== $token)
    {
      return response()->json(['error' => 'Unauthorized'], 401);
    }

    $request->validate([
      'firstname' => 'required|string',
      'name' => 'required|string',
      'street' => 'required|string',
      'street_no' => 'required|string',
      'zip' => 'required|string',
      'city' => 'required|string',
    ]);

    $fields = ['firstname', 'name', 'street', 'street_no', 'zip', 'city'];
    $criteria = $request->only($fields);

    $results = [
      'students' => [],
      'tutors' => [],
      'vip' => [],
    ];

    // Students
    $students = Student::where($criteria)->get();
    foreach ($students as $student)
    {
      $student->update(['is_invalid_address' => true]);
      $results['students'][] = [
        'id' => $student->id,
        'name' => $student->name,
        'firstname' => $student->firstname,
      ];
    }

    // Tutors
    $tutors = Tutor::where($criteria)->get();
    foreach ($tutors as $tutor)
    {
      $tutor->update(['is_invalid_address' => true]);
      $results['tutors'][] = [
        'id' => $tutor->id,
        'name' => $tutor->name,
        'firstname' => $tutor->firstname,
      ];
    }

    // VIP Addresses
    $vipAddresses = VipAddress::where($criteria)->get();
    foreach ($vipAddresses as $vipAddress)
    {
      $vipAddress->update(['is_invalid_address' => true]);
      $results['vip'][] = [
        'id' => $vipAddress->id,
        'name' => $vipAddress->name,
        'firstname' => $vipAddress->firstname,
      ];
    }

    $totalMatches = count($results['students']) + count($results['tutors']) + count($results['vip']);

    return response()->json([
      'success' => true,
      'total_matches' => $totalMatches,
      'matches' => $results,
    ]);
  }
}
