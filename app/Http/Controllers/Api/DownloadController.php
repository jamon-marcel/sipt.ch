<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\Download;
use App\Http\Requests\DownloadStoreRequest;
use App\Http\Requests\DownloadUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
	public function get()
	{
		$downloads = Download::orderBy('order')->get();
		return new DataCollection($downloads);
	}

	public function find(Download $download)
	{
		return response()->json($download);
	}

	public function store(DownloadStoreRequest $request)
	{
		$data = $request->only(['title', 'is_published', 'file']);

		$download = Download::create($data);
		return response()->json($download);
	}

	public function update(DownloadUpdateRequest $request, Download $download)
	{
		$data = $request->only(['title', 'is_published']);

		// Handle file replacement if a new file is uploaded
		if ($request->has('file') && $request->input('file')) {
			$newFile = $request->input('file');

			// Delete old file if it exists and is different from new file
			if ($download->file && $download->file !== $newFile) {
				$oldFilePath = 'uploads/' . $download->file;
				if (Storage::disk('public')->exists($oldFilePath)) {
					Storage::disk('public')->delete($oldFilePath);
				}
			}

			$data['file'] = $newFile;
		}

		$download->update($data);
		return response()->json($download);
	}

	public function order(Request $request)
	{
		foreach ($request->ids as $index => $downloadId)
		{
			Download::where('id', $downloadId)->update(['order' => $index]);
		}
		return response()->json('successfully ordered');
	}

	public function toggle(Download $download)
	{
		$download->is_published = $download->is_published == 0 ? 1 : 0;
		$download->save();
		return response()->json($download->is_published);
	}

	public function destroy(Download $download)
	{
		// Delete associated file
		if ($download->file) {
			$filePath = 'uploads/' . $download->file;
			if (Storage::disk('public')->exists($filePath)) {
				Storage::disk('public')->delete($filePath);
			}
		}

		$download->delete();
		return response()->json('successfully deleted');
	}
}
