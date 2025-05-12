<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\NewsArticle;
use App\Http\Requests\NewsArticleStoreRequest;
use Illuminate\Http\Request;

class NewsArticleController extends Controller
{
  public function get()
  {
    return new DataCollection(NewsArticle::all());
  }

  public function find(NewsArticle $newsArticle)
  {
    return response()->json($newsArticle);
  }

  public function store(NewsArticleStoreRequest $request)
  {
    $newsArticle = NewsArticle::create($request->all());
    return response()->json($newsArticle);
  }

  public function update(NewsArticleStoreRequest $request, NewsArticle $newsArticle)
  {
    $newsArticle->update($request->all());
    return response()->json($newsArticle);
  }

  public function destroy(NewsArticle $newsArticle)
  {
    $newsArticle->delete();
    return response()->json('successfully deleted');
  }
}
