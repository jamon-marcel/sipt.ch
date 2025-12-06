<?php

namespace App\Services\Chatbot;

use Illuminate\Support\Facades\Http;

class EmbeddingService
{
    protected string $apiKey;
    protected string $model;

    public function __construct()
    {
        $this->apiKey = config('chatbot.openai_api_key');
        $this->model = config('chatbot.embedding_model', 'text-embedding-3-small');
    }

    /**
     * Generate embedding for a single text
     */
    public function embed(string $text): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/embeddings', [
            'model' => $this->model,
            'input' => $text,
        ]);

        if (!$response->successful()) {
            throw new \Exception('OpenAI API error: ' . $response->body());
        }

        return $response->json('data.0.embedding');
    }

    /**
     * Generate embeddings for multiple texts (batch)
     */
    public function embedBatch(array $texts): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/embeddings', [
            'model' => $this->model,
            'input' => $texts,
        ]);

        if (!$response->successful()) {
            throw new \Exception('OpenAI API error: ' . $response->body());
        }

        return collect($response->json('data'))
            ->sortBy('index')
            ->pluck('embedding')
            ->toArray();
    }

    /**
     * Get the dimension of the embedding model
     */
    public function getDimension(): int
    {
        return match ($this->model) {
            'text-embedding-3-small' => 1536,
            'text-embedding-3-large' => 3072,
            'text-embedding-ada-002' => 1536,
            default => 1536,
        };
    }
}
