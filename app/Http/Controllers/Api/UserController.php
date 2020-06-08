<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */

  public function register(UserRegisterRequest $request)
  {
    $user = User::create([
      'email' => $request->input('email'),
      'password' => Hash::make(Str::random(16)),
      'role' => 'tutor'
    ]);
    return response()->json(['userId' => $user->id]);
  }

}
