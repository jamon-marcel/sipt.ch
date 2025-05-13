<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\NewsCategory;
use App\Http\Requests\NewsCategoryStoreRequest;
use Illuminate\Http\Request;

class NewsCategoryController extends Controller
{
  public function get()
  {
    return new DataCollection(NewsCategory::orderBy('order')->get());
  }

  public function store(NewsCategoryStoreRequest $request)
  {
    $newsCategory = NewsCategory::create($request->all());
    return response()->json($newsCategory);
  }

  public function update(NewsCategoryStoreRequest $request, NewsCategory $newsCategory)
  {
    $newsCategory->update($request->all());
    return response()->json($newsCategory);
  }

  public function toggle(NewsCategory $newsCategory)
  {
    $newsCategory->is_published = $newsCategory->is_published == 0 ? 1 : 0;
    $newsCategory->save();
    return response()->json($newsCategory->is_published);
  }

  public function order(Request $request)
  {
    $ids = $request->ids;
    foreach ($ids as $index => $id)
    {
      $newsCategory = NewsCategory::find($id);
      $newsCategory->order = $index;
      $newsCategory->save();
    }
    return response()->json('successfully ordered');
  }

  public function destroy(NewsCategory $newsCategory)
  {
    $newsCategory->delete();
    return response()->json('successfully deleted');
  }
}