<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\VipAddress;
use App\Http\Requests\VipAddressStoreRequest;
use Illuminate\Http\Request;

class VipAddressController extends Controller
{

  public function __construct(VipAddress $vipAddress)
  {
    $this->vipAddress = $vipAddress;
  }

  /**
   * Get a list of addresses
   *
   * @return \Illuminate\Http\Response
   */
  public function get()
  {
    $addresses = $this->vipAddress->orderBy('name')->get();
    return new DataCollection($addresses);
  }

  /**
   * Get a single vipAddress for a given vipAddress
   *
   * @param VipAddress $vipAddress
   * @return \Illuminate\Http\Response
   */
  public function find(VipAddress $vipAddress)
  {
    $vipAddress = $this->vipAddress->find($vipAddress->id);
    return response()->json($vipAddress);
  }

  /**
   * Store a newly created vipAddress
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(VipAddressStoreRequest $request)
  {
    $vipAddress = VipAddress::create($request->all());
    $vipAddress->save();
    return response()->json(['vipAddressId' => $vipAddress->id]);
  }

  /**
   * Update the current vipAddress
   *
   * @param VipAddress $vipAddress
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function update(VipAddress $vipAddress, VipAddressStoreRequest $request)
  {
    $vipAddress->update($request->all());
    $vipAddress->save();
    return response()->json('successfully updated');
  }

  /**
   * Remove a vipAddress by a given vipAddress
   *
   * @param  VipAddress $vipAddress
   * @return \Illuminate\Http\Response
   */
  public function destroy(VipAddress $vipAddress)
  {
    $vipAddress->delete();
    return response()->json('successfully deleted');
  }
}
