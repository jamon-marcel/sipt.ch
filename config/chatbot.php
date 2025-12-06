<?php

return [
    /*
    |--------------------------------------------------------------------------
    | OpenAI Configuration
    |--------------------------------------------------------------------------
    */
    'openai_api_key' => env('OPENAI_API_KEY'),
    'embedding_model' => env('CHATBOT_EMBEDDING_MODEL', 'text-embedding-3-small'),
    'chat_model' => env('CHATBOT_CHAT_MODEL', 'gpt-4o-mini'),

    /*
    |--------------------------------------------------------------------------
    | Qdrant Configuration
    |--------------------------------------------------------------------------
    */
    'qdrant_host' => env('QDRANT_HOST', 'http://localhost:6333'),
    'qdrant_api_key' => env('QDRANT_API_KEY'),
    'qdrant_collection' => env('QDRANT_COLLECTION', 'sipt_chatbot'),

    /*
    |--------------------------------------------------------------------------
    | RAG Settings
    |--------------------------------------------------------------------------
    */
    'search_limit' => env('CHATBOT_SEARCH_LIMIT', 5),
    'score_threshold' => env('CHATBOT_SCORE_THRESHOLD', 0.4),

    /*
    |--------------------------------------------------------------------------
    | Knowledge Base Path
    |--------------------------------------------------------------------------
    */
    'knowledge_base_path' => storage_path('app/chatbot/knowledge'),
];
