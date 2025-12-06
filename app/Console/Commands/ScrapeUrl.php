<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class ScrapeUrl extends Command
{
    protected $signature = 'scrape:url 
                            {url : The URL to scrape}
                            {--selector=main.site : CSS selector to extract content}
                            {--output= : Optional file path to save the output (.md extension recommended)}';

    protected $description = 'Scrape content from a URL using a CSS selector';

    public function handle()
    {
        $url = $this->argument('url');
        $selector = $this->option('selector');
        $outputFile = $this->option('output');

        $this->info("Fetching: {$url}");
        $this->info("Selector: {$selector}");

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (compatible; SiptScraper/1.0)',
                ])
                ->get($url);

            if (!$response->successful()) {
                $this->error("Failed to fetch URL. Status: {$response->status()}");
                return Command::FAILURE;
            }

            $html = $response->body();
            $crawler = new Crawler($html);

            $elements = $crawler->filter($selector);

            if ($elements->count() === 0) {
                $this->warn("No elements found matching selector: {$selector}");
                return Command::FAILURE;
            }

            $this->info("Found {$elements->count()} element(s)");
            $this->newLine();

            $content = $elements->each(function (Crawler $node) {
                return $this->htmlToMarkdown($node);
            });

            $output = implode("\n\n", $content);
            $output = $this->cleanMarkdown($output);

            // Generate filename from URL
            $filename = $outputFile ?: $this->generateFilename($url);
            $path = storage_path('app/chatbot/knowledge/' . $filename);

            // Ensure directory exists
            if (!is_dir(dirname($path))) {
                mkdir(dirname($path), 0755, true);
            }

            file_put_contents($path, $output);
            $this->info("Content saved to: {$path}");

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("Error: {$e->getMessage()}");
            return Command::FAILURE;
        }
    }

    /**
     * Convert HTML node to markdown text
     */
    protected function htmlToMarkdown(Crawler $node): string
    {
        $html = $node->html();

        // Convert headings
        $html = preg_replace('/<h1[^>]*>(.*?)<\/h1>/is', "\n# $1\n", $html);
        $html = preg_replace('/<h2[^>]*>(.*?)<\/h2>/is', "\n## $1\n", $html);
        $html = preg_replace('/<h3[^>]*>(.*?)<\/h3>/is', "\n### $1\n", $html);
        $html = preg_replace('/<h4[^>]*>(.*?)<\/h4>/is', "\n#### $1\n", $html);
        $html = preg_replace('/<h5[^>]*>(.*?)<\/h5>/is', "\n##### $1\n", $html);
        $html = preg_replace('/<h6[^>]*>(.*?)<\/h6>/is', "\n###### $1\n", $html);

        // Convert links
        $html = preg_replace('/<a[^>]*href=["\']([^"\']*)["\'][^>]*>(.*?)<\/a>/is', '[$2]($1)', $html);

        // Convert bold and italic
        $html = preg_replace('/<(strong|b)[^>]*>(.*?)<\/(strong|b)>/is', '**$2**', $html);
        $html = preg_replace('/<(em|i)[^>]*>(.*?)<\/(em|i)>/is', '*$2*', $html);

        // Convert lists
        $html = preg_replace('/<li[^>]*>(.*?)<\/li>/is', "- $1\n", $html);
        $html = preg_replace('/<\/?[uo]l[^>]*>/is', "\n", $html);

        // Convert paragraphs and line breaks
        $html = preg_replace('/<p[^>]*>(.*?)<\/p>/is', "$1\n\n", $html);
        $html = preg_replace('/<br\s*\/?>/is', "\n", $html);
        $html = preg_replace('/<hr\s*\/?>/is', "\n---\n", $html);

        // Remove remaining HTML tags
        $html = strip_tags($html);

        // Decode HTML entities
        $html = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return $html;
    }

    /**
     * Generate a filename from URL
     */
    protected function generateFilename(string $url): string
    {
        $parsed = parse_url($url);
        $path = $parsed['path'] ?? '';
        
        // Create filename from path or use 'index' for root
        $name = trim($path, '/');
        $name = $name ?: 'index';
        $name = str_replace('/', '-', $name);
        $name = preg_replace('/[^a-zA-Z0-9\-_]/', '', $name);
        
        return $name . '.md';
    }

    /**
     * Clean up markdown output
     */
    protected function cleanMarkdown(string $text): string
    {
        // Normalize line endings
        $text = str_replace("\r\n", "\n", $text);
        $text = str_replace("\r", "\n", $text);

        // Remove excessive whitespace
        $text = preg_replace('/[ \t]+/', ' ', $text);
        $text = preg_replace('/\n{3,}/', "\n\n", $text);

        // Trim lines
        $lines = explode("\n", $text);
        $lines = array_map('trim', $lines);
        $text = implode("\n", $lines);

        // Remove empty lines at start/end
        $text = trim($text);

        return $text;
    }
}
