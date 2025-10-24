<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\Therapist;
use Illuminate\Http\Request;

class TherapistController extends Controller
{
	public function get()
	{
		$therapists = Therapist::orderBy('order')->get();
		return new DataCollection($therapists);
	}

	public function find(Therapist $therapist)
	{
		return response()->json($therapist);
	}

	public function store(Request $request)
	{
		$request->validate([
			'firstname' => 'required|string|max:255',
			'name' => 'required|string|max:255',
			'country' => 'required|in:Germany,Switzerland',
		]);

		$data = $request->only(['firstname', 'name', 'country', 'description', 'is_published']);

		$therapist = Therapist::create($data);
		return response()->json($therapist);
	}

	public function update(Request $request, Therapist $therapist)
	{
		$request->validate([
			'firstname' => 'required|string|max:255',
			'name' => 'required|string|max:255',
			'country' => 'required|in:Germany,Switzerland',
		]);

		$data = $request->only(['firstname', 'name', 'country', 'description', 'is_published']);

		$therapist->update($data);
		return response()->json($therapist);
	}

	public function order(Request $request)
	{
		foreach ($request->ids as $index => $therapistId)
		{
			Therapist::where('id', $therapistId)->update(['order' => $index]);
		}
		return response()->json('successfully ordered');
	}

	public function toggle(Therapist $therapist)
	{
		$therapist->is_published = $therapist->is_published == 0 ? 1 : 0;
		$therapist->save();
		return response()->json($therapist->is_published);
	}

	public function destroy(Therapist $therapist)
	{
		$therapist->delete();
		return response()->json('successfully deleted');
	}
}
