<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class FaqBotController extends Controller
{
    public function handle(Request $request)
    {
        $q = trim(Str::lower($request->input('q', '')));

        $kb = Cache::remember('faq_kb_v1', 3600, function () {
            return json_decode(file_get_contents(storage_path('app/public/faq.json')), true);
        });

        // If no query → return available topics
        if ($q === '') {
            return response()->json([
                'status' => 'ok',
                'suggestions' => collect($kb['intents'])->pluck('id'),
            ]);
        }

        $best = null;
        $bestScore = 0;

        foreach ($kb['intents'] as $intent) {
            $score = 0;
            $patterns = $intent['patterns'] ?? [];

            // Ensure patterns is an array
            if (!is_array($patterns)) {
                continue;
            }

            foreach ($patterns as $p) {
                // Skip if pattern is not a string
                if (!is_string($p)) {
                    continue;
                }

                $p = Str::lower(trim($p));
                if ($q === $p) { $score += 5; }
                if (Str::contains($q, $p)) { $score += 3; }
                if (strlen($q) < 255 && strlen($p) < 255 && levenshtein($q, $p) <= 2) { $score += 1; }
            }

            if ($score > $bestScore) {
                $bestScore = $score;
                $best = $intent;
            }
        }

        // Simple query logging (no PII)
        info('faqbot_query', [
            'query' => $q,
            'intent' => $best['id'] ?? null,
            'score' => $bestScore,
        ]);

        if (!$best || $bestScore < 2) {
            return response()->json([
                'status' => 'fallback',
                'message' => $kb['fallback'],
                'escalation' => $kb['escalation'],
            ]);
        }

        return response()->json([
            'status' => 'ok',
            'intent' => $best['id'],
            'answer' => $best['answer'],
            'links' => $best['links'] ?? [],
        ]);
    }
}
