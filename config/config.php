<?php

// Config values
return [
    'api_key' => $_ENV['MISTRAL_API_KEY'] ?? null,
    'model' => $_ENV['MODEL'] ?? 'llama-3.1-8b-instant',
    'endpoint' => 'https://api.groq.com/openai/v1/chat/completions'
];
