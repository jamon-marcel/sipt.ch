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
    return new DataCollection(NewsCategory::all());
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

  public function destroy(NewsCategory $newsCategory)
  {
    $newsCategory->delete();
    return response()->json('successfully deleted');
  }
}