<?php

// Config values
return [
    'api_key' => $_ENV['MISTRAL_API_KEY'] ?? null,
    'model' => $_ENV['MODEL'] ?? 'open-mistral-7b',
    'endpoint' => 'https://api.mistral.ai/v1/chat/completionss'
];
