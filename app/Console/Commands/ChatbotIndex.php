<?php

namespace App\Console\Commands;

use App\Services\Chatbot\EmbeddingService;
use App\Services\Chatbot\QdrantService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ChatbotIndex extends Command
{
    protected $signature = 'chatbot:index 
                            {--fresh : Delete existing collection and reindex}
                            {--source= : Path to knowledge base (default: storage/app/chatbot/knowledge)}';

    protected $description = 'Index knowledge base documents into Qdrant for RAG chatbot';

    protected EmbeddingService $embedding;
    protected QdrantService $qdrant;

    public function __construct(EmbeddingService $embedding, QdrantService $qdrant)
    {
        parent::__construct();
        $this->embedding = $embedding;
        $this->qdrant = $qdrant;
    }

    public function handle()
    {
        $sourcePath = $this->option('source') ?? config('chatbot.knowledge_base_path');

        if (!File::isDirectory($sourcePath)) {
            $this->error("Knowledge base directory not found: {$sourcePath}");
            $this->info("Creating directory and sample files...");
            $this->createSampleKnowledgeBase($sourcePath);
        }

        // Fresh index - delete existing collection
        if ($this->option('fresh')) {
            $this->info('Deleting existing collection...');
            $this->qdrant->deleteCollection();
        }

        // Create collection
        $this->info('Creating/verifying Qdrant collection...');
        $dimension = $this->embedding->getDimension();
        $this->qdrant->createCollection($dimension);

        // Load and process documents
        $this->info('Loading documents...');
        $documents = $this->loadDocuments($sourcePath);
        
        if (empty($documents)) {
            $this->warn('No documents found to index.');
            return 0;
        }

        $this->info("Found " . count($documents) . " document chunks.");

        // Generate embeddings and upsert in batches
        $batchSize = 20;
        $batches = array_chunk($documents, $batchSize);
        $bar = $this->output->createProgressBar(count($batches));

        foreach ($batches as $batch) {
            $texts = array_column($batch, 'content');
            $embeddings = $this->embedding->embedBatch($texts);

            $points = [];
            foreach ($batch as $i => $doc) {
                $points[] = [
                    'id' => QdrantService::generateId(),
                    'vector' => $embeddings[$i],
                    'payload' => [
                        'content' => $doc['content'],
                        'title' => $doc['title'] ?? null,
                        'url' => $doc['url'] ?? null,
                        'source' => $doc['source'] ?? null,
                    ],
                ];
            }

            $this->qdrant->upsert($points);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Indexing complete!');

        // Show collection info
        $info = $this->qdrant->getCollectionInfo();
        $this->table(
            ['Metric', 'Value'],
            [
                ['Collection', config('chatbot.qdrant_collection')],
                ['Points', $info['points_count'] ?? 'N/A'],
                ['Status', $info['status'] ?? 'N/A'],
            ]
        );

        return 0;
    }

    /**
     * Load documents from the knowledge base directory
     */
    protected function loadDocuments(string $path): array
    {
        $documents = [];
        $files = File::allFiles($path);

        foreach ($files as $file) {
            $extension = $file->getExtension();
            
            if (!in_array($extension, ['md', 'txt', 'json'])) {
                continue;
            }

            $content = File::get($file->getPathname());
            $filename = $file->getFilenameWithoutExtension();

            if ($extension === 'json') {
                $data = json_decode($content, true);
                if (is_array($data)) {
                    foreach ($data as $item) {
                        if (isset($item['content'])) {
                            $documents[] = $item;
                        }
                    }
                }
            } else {
                // Split by sections (## headers) or paragraphs
                $chunks = $this->chunkText($content, $filename);
                $documents = array_merge($documents, $chunks);
            }
        }

        return $documents;
    }

    /**
     * Split text into chunks
     */
    protected function chunkText(string $text, string $source, int $maxChunkSize = 800): array
    {
        $chunks = [];
        
        // Split by any markdown header (##, ###, etc.) but keep the header with content
        // Match pattern: header line followed by content until next header or end
        preg_match_all('/^(#{2,})\s+(.+?)$(.*?)(?=^#{2,}\s|\z)/ms', $text, $matches, PREG_SET_ORDER);
        
        // If no headers found, treat entire text as one chunk
        if (empty($matches)) {
            $cleanText = trim($text);
            if (!empty($cleanText)) {
                $chunks[] = [
                    'content' => $cleanText,
                    'title' => $source,
                    'source' => $source,
                ];
            }
            return $chunks;
        }

        foreach ($matches as $match) {
            $title = trim($match[2]);
            $content = trim($match[3]);
            
            // Combine title and content for better context
            $fullContent = "**{$title}**\n\n{$content}";
            $fullContent = trim($fullContent);
            
            if (empty($content)) continue;

            // If content is too long, split by paragraphs
            if (strlen($fullContent) > $maxChunkSize) {
                $paragraphs = preg_split('/\n\n+/', $content);
                $currentChunk = "**{$title}**\n\n";
                
                foreach ($paragraphs as $para) {
                    $para = trim($para);
                    if (empty($para)) continue;
                    
                    if (strlen($currentChunk) + strlen($para) > $maxChunkSize && strlen($currentChunk) > 50) {
                        $chunks[] = [
                            'content' => trim($currentChunk),
                            'title' => $title,
                            'source' => $source,
                        ];
                        $currentChunk = "**{$title}** (Fortsetzung)\n\n" . $para;
                    } else {
                        $currentChunk .= $para . "\n\n";
                    }
                }
                
                if (strlen(trim($currentChunk)) > 50) {
                    $chunks[] = [
                        'content' => trim($currentChunk),
                        'title' => $title,
                        'source' => $source,
                    ];
                }
            } else {
                $chunks[] = [
                    'content' => $fullContent,
                    'title' => $title,
                    'source' => $source,
                ];
            }
        }

        return $chunks;
    }

    /**
     * Create sample knowledge base files
     */
    protected function createSampleKnowledgeBase(string $path): void
    {
        File::makeDirectory($path, 0755, true);

        $sampleContent = <<<'MD'
## Über das SIPT

Das Schweizerische Institut für Psychotraumatologie (SIPT) ist ein führendes Weiterbildungsinstitut für Traumatherapie in der Schweiz. Wir bieten praxisnahe Aus- und Weiterbildungen für Fachpersonen aus dem Gesundheits- und Sozialwesen an.

## Kosten und Gebühren

Die Kursgebühren variieren je nach Weiterbildung. Ein CAS-Lehrgang kostet in der Regel zwischen CHF 8'000 und CHF 12'000. Einzelne Kurse sind ab CHF 400 buchbar. Ratenzahlung ist auf Anfrage möglich.

## CAS Abschluss

Der CAS (Certificate of Advanced Studies) in Psychotraumatologie umfasst 15 ECTS-Punkte und wird in Zusammenarbeit mit einer Schweizer Hochschule vergeben. Die Weiterbildung dauert ca. 18 Monate berufsbegleitend.

## Anmeldung

Die Anmeldung erfolgt online über unsere Website. Nach der Anmeldung erhalten Sie eine Bestätigung per E-Mail. Bei Fragen zur Anmeldung kontaktieren Sie bitte unser Sekretariat.

## Kontakt

Sekretariat SIPT
E-Mail: info@sipt.ch
Telefon: +41 44 xxx xx xx
Öffnungszeiten: Mo-Fr 9:00-12:00 und 14:00-17:00
MD;

        File::put($path . '/general.md', $sampleContent);
        $this->info("Created sample knowledge base at: {$path}");
    }
}
