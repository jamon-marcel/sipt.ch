<?php

namespace App\Services\Chatbot;

use Illuminate\Support\Facades\Http;

class ChatService
{
    protected string $apiKey;
    protected string $model;

    public function __construct()
    {
        $this->apiKey = config('chatbot.openai_api_key');
        $this->model = config('chatbot.chat_model', 'gpt-4o-mini');
    }

    /**
     * Generate a response using RAG context
     */
    public function generate(string $question, array $context, array $conversationHistory = []): string
    {
        $systemPrompt = $this->buildSystemPrompt($context);
        
        $messages = [
            ['role' => 'system', 'content' => $systemPrompt],
        ];

        // Add conversation history (last 6 messages max)
        foreach (array_slice($conversationHistory, -6) as $msg) {
            $messages[] = $msg;
        }

        $messages[] = ['role' => 'user', 'content' => $question];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->timeout(30)->post('https://api.openai.com/v1/chat/completions', [
            'model' => $this->model,
            'messages' => $messages,
            'temperature' => 0.7,
            'max_tokens' => 500,
        ]);

        if (!$response->successful()) {
            throw new \Exception('OpenAI Chat API error: ' . $response->body());
        }

        return $response->json('choices.0.message.content', '');
    }

    /**
     * Build the system prompt with context
     */
    protected function buildSystemPrompt(array $context): string
    {
        $contextText = collect($context)
            ->map(fn($doc, $i) => "[$i] " . ($doc['payload']['content'] ?? ''))
            ->implode("\n\n");

        return <<<PROMPT
Du bist ein hilfreicher Assistent für das SIPT (Schweizerisches Institut für Psychotraumatologie).
Beantworte Fragen basierend auf dem folgenden Kontext. 
Antworte auf Deutsch, freundlich und präzise.
Wenn du die Antwort nicht im Kontext findest, sage ehrlich, dass du es nicht weisst und empfehle, das Sekretariat zu kontaktieren.

KONTEXT:
{$contextText}

WICHTIG:
- Antworte nur basierend auf dem gegebenen Kontext
– Antworten sollen so ausführlich wie möglich sein
- Verwende eine freundliche, professionelle Sprache
- Verwende keine Ausrufezeichen
- Bei Unsicherheit: Empfehle Kontakt zum Sekretariat unter [info@sipt.ch](mailto:info@sipt.ch) oder +41 (0)71 886 48 24
- Wenn du auf das Sekretariat verweist, gib immer die Kontaktdaten an: [info@sipt.ch](mailto:info@sipt.ch), +41 (0)71 886 48 24
- Füge bei passenden Antworten einen Hinweis auf die FAQ-Seite hinzu, z.B. "Weitere Informationen finden Sie auf unserer [FAQ-Seite](/faq)."
- Wenn im Kontext Links im Format [Text](/url) vorhanden sind, übernimm diese EXAKT in deine Antwort
PROMPT;
    }
}
