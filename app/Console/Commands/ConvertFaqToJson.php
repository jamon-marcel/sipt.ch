<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ConvertFaqToJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'faq:convert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert FAQ markdown to JSON format for the chatbot';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mdPath = storage_path('app/public/faq.md');
        $jsonPath = storage_path('app/public/faq.json');

        if (!file_exists($mdPath)) {
            $this->error("FAQ markdown file not found at: {$mdPath}");
            return 1;
        }

        $this->info('Reading FAQ markdown...');
        $content = file_get_contents($mdPath);

        $this->info('Parsing markdown and extracting Q&A...');
        $intents = $this->parseMarkdown($content);

        $this->info("Extracted {$intents->count()} FAQ items.");

        $jsonData = [
            'fallback' => 'Tut mir leid, dazu habe ich keine passende Antwort gefunden.',
            'escalation' => 'Für weitere Fragen wenden Sie sich gerne an: Prof. Dr. phil. habil. Rosmarie Barwinski, <a href="mailto:rb@sipt.ch">rb@sipt.ch</a>',
            'intents' => $intents->toArray(),
        ];

        $this->info('Writing JSON file...');
        file_put_contents($jsonPath, json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $this->info("✓ Successfully converted FAQ to: {$jsonPath}");
        $this->info("  Run 'php artisan cache:clear' to refresh the chatbot cache.");

        return 0;
    }

    protected function parseMarkdown(string $content)
    {
        $lines = explode("\n", $content);
        $intents = collect();
        $currentSection = '';
        $currentQuestion = null;
        $currentAnswer = '';

        foreach ($lines as $line) {
            $line = trim($line);

            // Main section heading (##)
            if (preg_match('/^## (.+)$/', $line, $matches)) {
                $currentSection = $matches[1];
                continue;
            }

            // Question heading (###)
            if (preg_match('/^### (.+)$/', $line, $matches)) {
                // Save previous Q&A if exists
                if ($currentQuestion) {
                    $intents->push($this->buildIntent($currentQuestion, trim($currentAnswer), $currentSection));
                }

                $currentQuestion = $matches[1];
                $currentAnswer = '';
                continue;
            }

            // Skip horizontal rules and empty lines at the start
            if ($line === '---' || $line === '' || $line === '#') {
                if ($currentAnswer !== '') {
                    $currentAnswer .= "\n";
                }
                continue;
            }

            // Skip main title
            if (preg_match('/^# /', $line)) {
                continue;
            }

            // Accumulate answer content
            if ($currentQuestion) {
                $currentAnswer .= $line . "\n";
            }
        }

        // Don't forget the last Q&A
        if ($currentQuestion) {
            $intents->push($this->buildIntent($currentQuestion, trim($currentAnswer), $currentSection));
        }

        return $intents;
    }

    protected function buildIntent(string $question, string $answer, string $section)
    {
        // Generate unique ID from question
        $id = Str::slug(Str::limit($question, 50, ''), '_');

        // Generate a short label for buttons
        $label = $this->extractLabel($question);

        // Generate search patterns from question
        $patterns = $this->generatePatterns($question);

        // Convert markdown to HTML
        $htmlAnswer = $this->markdownToHtml($answer);

        return [
            'id' => $id,
            'label' => $label,
            'section' => $section,
            'patterns' => $patterns,
            'answer' => $htmlAnswer,
            'links' => [],
        ];
    }

    protected function extractLabel(string $question): string
    {
        // Try to extract key topic from question
        $question = str_replace('?', '', $question);

        // Common patterns to extract meaningful labels
        if (preg_match('/unterscheidet.+?«(.+?)»/i', $question, $m)) {
            return $m[1];
        }
        if (preg_match('/Was (ist|beinhaltet|zeichnet).+?«(.+?)»/i', $question, $m)) {
            return $m[2];
        }
        if (preg_match('/(Kosten|Abschluss|Module|Prüfung)/i', $question, $m)) {
            return $m[1];
        }

        // Fallback: use first few words
        $words = explode(' ', $question);
        return implode(' ', array_slice($words, 0, 3));
    }

    protected function generatePatterns(string $question): array
    {
        $patterns = [];

        // Add the full question (lowercased, without ?)
        $cleanQuestion = Str::lower(str_replace('?', '', $question));
        $patterns[] = $cleanQuestion;

        // Extract key words (nouns, important terms)
        $keywords = [
            'kosten', 'preis', 'gebühren', 'bezahlung', 'rechnung',
            'modul', 'module', 'kurs', 'kurse',
            'cas', 'abschluss', 'zertifikat', 'diplom',
            'fachberater', 'fachberaterin', 'traumapädagogik', 'traumatherapie',
            'pflicht', 'wahl', 'wahlmodul', 'pflichtmodul',
            'flexibel', 'reihenfolge', 'tempo',
            'beginn', 'start', 'anmeldung',
            'prüfung', 'arbeit', 'abschlussarbeit',
            'unterlagen', 'material',
            'supervision', 'ects', 'cpd',
            'wechsel', 'anrechnung',
            'unterschied', 'vergleich',
            'marktwert', 'mehrwert',
            'sipt', 'besonderheit',
            'fallkonzeption',
            'durchführung', 'bestätigung', 'informiert'
        ];

        foreach ($keywords as $keyword) {
            if (Str::contains($cleanQuestion, $keyword)) {
                $patterns[] = $keyword;
            }
        }

        return array_unique($patterns);
    }

    protected function markdownToHtml(string $markdown): string
    {
        $lines = explode("\n", $markdown);
        $html = '';
        $inUnorderedList = false;
        $inOrderedList = false;
        $currentListItem = null;
        $i = 0;

        while ($i < count($lines)) {
            $line = $lines[$i];
            $trimmed = trim($line);

            // Empty line
            if ($trimmed === '') {
                // Close current list item if any
                if ($currentListItem !== null) {
                    $html .= $this->formatListItemContent($currentListItem) . '</li>';
                    $currentListItem = null;
                }

                // Check if next line is also empty or a list item - if not, close the list
                if ($i + 1 < count($lines)) {
                    $nextTrimmed = trim($lines[$i + 1]);
                    if ($nextTrimmed !== '' && !preg_match('/^[-*]\s+/', $nextTrimmed) && !preg_match('/^\d+\.\s+/', $nextTrimmed)) {
                        if ($inUnorderedList) {
                            $html .= '</ul>';
                            $inUnorderedList = false;
                        }
                        if ($inOrderedList) {
                            $html .= '</ol>';
                            $inOrderedList = false;
                        }
                    }
                }

                $i++;
                continue;
            }

            // Unordered list item (- item or * item)
            if (preg_match('/^[-*]\s+(.+)$/', $trimmed, $matches)) {
                // Close previous list item if any
                if ($currentListItem !== null) {
                    $html .= $this->formatListItemContent($currentListItem) . '</li>';
                }

                // Start or continue unordered list
                if (!$inUnorderedList) {
                    if ($inOrderedList) {
                        $html .= '</ol>';
                        $inOrderedList = false;
                    }
                    $html .= '<ul>';
                    $inUnorderedList = true;
                }

                // Start new list item and collect its content
                $currentListItem = [$matches[1]];

                // Look ahead for continuation lines
                $j = $i + 1;
                while ($j < count($lines)) {
                    $nextLine = $lines[$j];
                    $nextTrimmed = trim($nextLine);

                    // Stop if we hit another list item
                    if (preg_match('/^[-*]\s+/', $nextTrimmed) || preg_match('/^\d+\.\s+/', $nextTrimmed)) {
                        break;
                    }

                    // Stop if we hit an empty line
                    if ($nextTrimmed === '') {
                        break;
                    }

                    // Add this line to current list item
                    $currentListItem[] = $nextTrimmed;
                    $j++;
                }

                $i = $j;
                continue;
            }

            // Ordered list item (1. item, 2. item, etc.)
            if (preg_match('/^\d+\.\s+(.+)$/', $trimmed, $matches)) {
                // Close previous list item if any
                if ($currentListItem !== null) {
                    $html .= $this->formatListItemContent($currentListItem) . '</li>';
                }

                // Start or continue ordered list
                if (!$inOrderedList) {
                    if ($inUnorderedList) {
                        $html .= '</ul>';
                        $inUnorderedList = false;
                    }
                    $html .= '<ol>';
                    $inOrderedList = true;
                }

                // Start new list item and collect its content
                $currentListItem = [$matches[1]];

                // Look ahead for continuation lines
                $j = $i + 1;
                while ($j < count($lines)) {
                    $nextLine = $lines[$j];
                    $nextTrimmed = trim($nextLine);

                    // Stop if we hit another list item
                    if (preg_match('/^[-*]\s+/', $nextTrimmed) || preg_match('/^\d+\.\s+/', $nextTrimmed)) {
                        break;
                    }

                    // Stop if we hit an empty line
                    if ($nextTrimmed === '') {
                        break;
                    }

                    // Add this line to current list item
                    $currentListItem[] = $nextTrimmed;
                    $j++;
                }

                $i = $j;
                continue;
            }

            // Regular paragraph (not in a list)
            if ($inUnorderedList) {
                if ($currentListItem !== null) {
                    $html .= $this->formatListItemContent($currentListItem) . '</li>';
                    $currentListItem = null;
                }
                $html .= '</ul>';
                $inUnorderedList = false;
            }
            if ($inOrderedList) {
                if ($currentListItem !== null) {
                    $html .= $this->formatListItemContent($currentListItem) . '</li>';
                    $currentListItem = null;
                }
                $html .= '</ol>';
                $inOrderedList = false;
            }

            $content = $this->convertInlineMarkdown($trimmed);
            $html .= "<p>{$content}</p>";
            $i++;
        }

        // Close any open list item
        if ($currentListItem !== null) {
            $html .= $this->formatListItemContent($currentListItem) . '</li>';
        }

        // Close any open lists at the end
        if ($inUnorderedList) {
            $html .= '</ul>';
        }
        if ($inOrderedList) {
            $html .= '</ol>';
        }

        return $html;
    }

    protected function formatListItemContent(array $lines): string
    {
        $html = '<li>';

        // First line is always inline with the bullet
        $html .= $this->convertInlineMarkdown($lines[0]);

        // Additional lines become paragraphs
        if (count($lines) > 1) {
            for ($i = 1; $i < count($lines); $i++) {
                $content = $this->convertInlineMarkdown($lines[$i]);
                $html .= "<p>{$content}</p>";
            }
        }

        return $html;
    }

    protected function convertInlineMarkdown(string $text): string
    {
        // Convert **bold** to <strong>
        $text = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $text);

        return $text;
    }
}
