<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollection;
use App\Models\NewsArticle;
use App\Models\NewsCategory;
use App\Http\Requests\NewsArticleStoreRequest;
use Illuminate\Http\Request;

class NewsArticleController extends Controller
{
  public function get()
  {
    return new DataCollection(
      NewsCategory::with('articles')->orderBy('order')->get()
    );
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

  public function order(Request $request, NewsCategory $newsCategory)
  {
    foreach ($request->ids as $index => $articleId)
    {
      NewsArticle::where('id', $articleId)->update(['order' => $index]);
    }
    return response()->json('successfully ordered');
  }


  public function toggle(NewsArticle $newsArticle)
  {
    $newsArticle->is_published = $newsArticle->is_published == 0 ? 1 : 0;
    $newsArticle->save();
    return response()->json($newsArticle->is_published);
  }

  public function destroy(NewsArticle $newsArticle)
  {
    $newsArticle->delete();
    return response()->json('successfully deleted');
  }
}
