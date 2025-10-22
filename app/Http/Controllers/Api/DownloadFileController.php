<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadFileController extends Controller
{
	/**
	 * Delete file from a download (edit mode)
	 */
	public function delete(Download $download)
	{
		// Delete the file from disk
		if ($download->file) {
			$filePath = 'uploads/' . $download->file;
			if (Storage::disk('public')->exists($filePath)) {
				Storage::disk('public')->delete($filePath);
			}
		}

		// Set file field to null
		$download->file = null;
		$download->save();

		return response()->json($download);
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
