<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\ResilienceTip;
use App\Http\Requests\ResilienceTipStoreRequest;
use App\Http\Requests\ResilienceTipUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResilienceTipController extends Controller
{
	public function get()
	{
		$tips = ResilienceTip::orderBy('order')->get();
		return new DataCollection($tips);
	}

	public function find(ResilienceTip $resilienceTip)
	{
		return response()->json($resilienceTip);
	}

	public function store(ResilienceTipStoreRequest $request)
	{
		$data = $request->only(['title', 'subtitle', 'description', 'published_at', 'is_published', 'file']);

		$tip = ResilienceTip::create($data);
		return response()->json($tip);
	}

	public function update(ResilienceTipUpdateRequest $request, ResilienceTip $resilienceTip)
	{
		$data = $request->only(['title', 'subtitle', 'description', 'published_at', 'is_published']);

		// Handle file replacement if a new file is uploaded
		if ($request->has('file') && $request->input('file')) {
			$newFile = $request->input('file');

			// Delete old file if it exists and is different from new file
			if ($resilienceTip->file && $resilienceTip->file !== $newFile) {
				$oldFilePath = 'uploads/' . $resilienceTip->file;
				if (Storage::disk('public')->exists($oldFilePath)) {
					Storage::disk('public')->delete($oldFilePath);
				}
			}

			$data['file'] = $newFile;
		}

		$resilienceTip->update($data);
		return response()->json($resilienceTip);
	}

	public function order(Request $request)
	{
		foreach ($request->ids as $index => $tipId)
		{
			ResilienceTip::where('id', $tipId)->update(['order' => $index]);
		}
		return response()->json('successfully ordered');
	}

	public function toggle(ResilienceTip $resilienceTip)
	{
		$resilienceTip->is_published = $resilienceTip->is_published == 0 ? 1 : 0;
		$resilienceTip->save();
		return response()->json($resilienceTip->is_published);
	}

	public function destroy(ResilienceTip $resilienceTip)
	{
		// Delete associated file
		if ($resilienceTip->file) {
			$filePath = 'uploads/' . $resilienceTip->file;
			if (Storage::disk('public')->exists($filePath)) {
				Storage::disk('public')->delete($filePath);
			}
		}

		$resilienceTip->delete();
		return response()->json('successfully deleted');
	}
}
