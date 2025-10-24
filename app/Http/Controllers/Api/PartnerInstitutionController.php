<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\PartnerInstitution;
use App\Http\Requests\PartnerInstitutionStoreRequest;
use App\Http\Requests\PartnerInstitutionUpdateRequest;
use Illuminate\Http\Request;

class PartnerInstitutionController extends Controller
{
	public function get()
	{
		$institutions = PartnerInstitution::orderBy('order')->get();
		return new DataCollection($institutions);
	}

	public function find(PartnerInstitution $partnerInstitution)
	{
		return response()->json($partnerInstitution);
	}

	public function store(PartnerInstitutionStoreRequest $request)
	{
		$data = $request->only(['name', 'description', 'is_published']);

		$institution = PartnerInstitution::create($data);
		return response()->json($institution);
	}

	public function update(PartnerInstitutionUpdateRequest $request, PartnerInstitution $partnerInstitution)
	{
		$data = $request->only(['name', 'description', 'is_published']);

		$partnerInstitution->update($data);
		return response()->json($partnerInstitution);
	}

	public function order(Request $request)
	{
		foreach ($request->ids as $index => $institutionId)
		{
			PartnerInstitution::where('id', $institutionId)->update(['order' => $index]);
		}
		return response()->json('successfully ordered');
	}

	public function toggle(PartnerInstitution $partnerInstitution)
	{
		$partnerInstitution->is_published = $partnerInstitution->is_published == 0 ? 1 : 0;
		$partnerInstitution->save();
		return response()->json($partnerInstitution->is_published);
	}

	public function destroy(PartnerInstitution $partnerInstitution)
	{
		$partnerInstitution->delete();
		return response()->json('successfully deleted');
	}
}
