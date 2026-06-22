<?php
namespace App\Tasks;

use App\Services\Chatbot\QdrantService;
use Illuminate\Support\Facades\Log;

class QdrantKeepAlive
{
  public function __invoke()
  {
    // Lightweight request to keep the Qdrant Cloud cluster from being
    // deleted due to inactivity. A collection-info GET counts as activity.
    try
    {
      $info = (new QdrantService)->getCollectionInfo();

      if ($info === null)
      {
        Log::warning('Qdrant keep-alive: request failed (no collection info returned).');
      }
    }
    catch (\Throwable $e)
    {
      Log::warning('Qdrant keep-alive: ' . $e->getMessage());
    }
  }
}
