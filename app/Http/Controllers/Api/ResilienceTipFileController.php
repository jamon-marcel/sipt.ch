<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ResilienceTip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResilienceTipFileController extends Controller
{
	/**
	 * Delete file from a resilience tip (edit mode)
	 */
	public function delete(ResilienceTip $resilienceTip)
	{
		// Delete the file from disk
		if ($resilienceTip->file) {
			$filePath = 'uploads/' . $resilienceTip->file;
			if (Storage::disk('public')->exists($filePath)) {
				Storage::disk('public')->delete($filePath);
			}
		}

		// Set file field to null
		$resilienceTip->file = null;
		$resilienceTip->save();

		return response()->json($resilienceTip);
	}

	/**
	 * Delete temporary uploaded file (create mode)
	 */
	public function deleteUpload(Request $request)
	{
		$filename = $request->input('filename');

		if ($filename) {
			$filePath = 'uploads/' . $filename;
			if (Storage::disk('public')->exists($filePath)) {
				Storage::disk('public')->delete($filePath);
			}
		}

		return response()->json(['message' => 'File deleted']);
	}
}
