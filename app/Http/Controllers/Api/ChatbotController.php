<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Chatbot\ChatService;
use App\Services\Chatbot\EmbeddingService;
use App\Services\Chatbot\QdrantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    protected EmbeddingService $embedding;
    protected QdrantService $qdrant;
    protected ChatService $chat;

    public function __construct(
        EmbeddingService $embedding,
        QdrantService $qdrant,
        ChatService $chat
    ) {
        $this->embedding = $embedding;
        $this->qdrant = $qdrant;
        $this->chat = $chat;
    }

    /**
     * Handle chatbot query
     */
    public function query(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:500',
            'history' => 'array|max:10',
        ]);

        $question = trim($request->input('question'));
        $history = $request->input('history', []);

        try {
            // Preprocess: expand single-word queries for better semantic matching
            $searchQuery = $this->expandQuery($question);

            // 1. Generate embedding for the question
            $questionVector = $this->embedding->embed($searchQuery);

            // 2. Search for relevant documents in Qdrant
            $results = $this->qdrant->search(
                $questionVector,
                config('chatbot.search_limit', 5),
                config('chatbot.score_threshold', 0.7)
            );

            // 3. If no relevant context found, return fallback
            if (empty($results)) {
                return response()->json([
                    'status' => 'fallback',
                    'answer' => 'Leider konnte ich keine passende Antwort finden. Bitte kontaktieren Sie unser Sekretariat für weitere Informationen.',
                    'sources' => [],
                ]);
            }

            // 4. Generate response using LLM with context
            $answer = $this->chat->generate($question, $results, $history);

            // 5. Extract source references
            $sources = collect($results)
                ->map(fn($r) => [
                    'title' => $r['payload']['title'] ?? null,
                    'url' => $r['payload']['url'] ?? null,
                    'score' => round($r['score'], 2),
                ])
                ->filter(fn($s) => $s['title'] || $s['url'])
                ->unique('title')
                ->values()
                ->toArray();

            // Log query for analytics
            Log::info('chatbot_query', [
                'question' => $question,
                'results_count' => count($results),
                'top_score' => $results[0]['score'] ?? 0,
            ]);

            return response()->json([
                'status' => 'ok',
                'answer' => $answer,
                'sources' => $sources,
            ]);

        } catch (\Exception $e) {
            Log::error('chatbot_error', [
                'question' => $question,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'answer' => 'Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später erneut.',
                'sources' => [],
            ], 500);
        }
    }

    /**
     * Health check endpoint
     */
    public function health()
    {
        try {
            $info = $this->qdrant->getCollectionInfo();

            return response()->json([
                'status' => 'ok',
                'qdrant' => $info ? 'connected' : 'not configured',
                'collection' => config('chatbot.qdrant_collection'),
                'points_count' => $info['points_count'] ?? 0,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Expand short/single-word queries for better semantic matching
     */
    protected function expandQuery(string $question): string
    {
        $question = trim($question);
        $wordCount = str_word_count($question);

        // If it's a single word or very short query without question mark, expand it
        if ($wordCount <= 2 && !str_contains($question, '?')) {
            return "Was sind die Informationen zu {$question}?";
        }

        return $question;
    }
}
