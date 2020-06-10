<?php
namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Models\Administrator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdministratorController extends Controller
{
  public function __construct(Administrator $administrator)
  {
    $this->administrator = $administrator;
  }

  /**
   * Get the administrator
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $admin = $this->administrator->with('user')
                                 ->where('user_id', '=', auth()->user()->id)
                                 ->first();
    return response()->json($admin);
  }
}
