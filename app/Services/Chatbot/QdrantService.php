<?php

namespace App\Services\Chatbot;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class QdrantService
{
    protected string $host;
    protected ?string $apiKey;
    protected string $collection;

    public function __construct()
    {
        $this->host = config('chatbot.qdrant_host', 'http://localhost:6333');
        $this->apiKey = config('chatbot.qdrant_api_key');
        $this->collection = config('chatbot.qdrant_collection', 'chatbot');
    }

    /**
     * Get HTTP client with auth headers
     */
    protected function client()
    {
        $http = Http::baseUrl($this->host);
        
        if ($this->apiKey) {
            $http = $http->withHeaders(['api-key' => $this->apiKey]);
        }

        return $http;
    }

    /**
     * Create collection if it doesn't exist
     */
    public function createCollection(int $dimension): bool
    {
        // Check if collection exists
        $response = $this->client()->get("/collections/{$this->collection}");
        
        if ($response->successful()) {
            return true; // Already exists
        }

        // Create collection
        $response = $this->client()->put("/collections/{$this->collection}", [
            'vectors' => [
                'size' => $dimension,
                'distance' => 'Cosine',
            ],
        ]);

        return $response->successful();
    }

    /**
     * Delete collection
     */
    public function deleteCollection(): bool
    {
        $response = $this->client()->delete("/collections/{$this->collection}");
        return $response->successful();
    }

    /**
     * Upsert points (documents with embeddings)
     */
    public function upsert(array $points): bool
    {
        $response = $this->client()->put("/collections/{$this->collection}/points", [
            'points' => $points,
        ]);

        if (!$response->successful()) {
            throw new \Exception('Qdrant upsert error: ' . $response->body());
        }

        return true;
    }

    /**
     * Search for similar documents
     */
    public function search(array $vector, int $limit = 5, float $scoreThreshold = 0.7): array
    {
        $response = $this->client()->post("/collections/{$this->collection}/points/search", [
            'vector' => $vector,
            'limit' => $limit,
            'with_payload' => true,
            'score_threshold' => $scoreThreshold,
        ]);

        if (!$response->successful()) {
            throw new \Exception('Qdrant search error: ' . $response->body());
        }

        return $response->json('result', []);
    }

    /**
     * Get collection info
     */
    public function getCollectionInfo(): ?array
    {
        $response = $this->client()->get("/collections/{$this->collection}");
        
        if (!$response->successful()) {
            return null;
        }

        return $response->json('result');
    }

    /**
     * Generate a UUID for a point
     */
    public static function generateId(): string
    {
        return (string) Str::uuid();
    }
}
