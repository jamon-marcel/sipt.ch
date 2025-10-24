<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TherapistIntro;
use Illuminate\Http\Request;

class TherapistIntroController extends Controller
{
	public function get()
	{
		$intro = TherapistIntro::first();

		if (!$intro) {
			$intro = TherapistIntro::create(['content' => '']);
		}

		return response()->json($intro);
	}

	public function update(Request $request)
	{
		$intro = TherapistIntro::first();

		if (!$intro) {
			$intro = TherapistIntro::create(['content' => $request->input('content', '')]);
		} else {
			$intro->update(['content' => $request->input('content', '')]);
		}

		return response()->json($intro);
	}

	public function toggle()
	{
		$intro = TherapistIntro::first();

		if (!$intro) {
			$intro = TherapistIntro::create(['content' => '', 'is_published' => 0]);
		} else {
			$intro->is_published = $intro->is_published == 0 ? 1 : 0;
			$intro->save();
		}

		return response()->json($intro->is_published);
	}
}
