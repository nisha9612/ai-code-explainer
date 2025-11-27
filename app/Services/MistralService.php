<?php

namespace App\Services;

class MistralService
{
    private string $apiKey;
    private string $model;

    public function __construct()
    {
        $this->apiKey = $_ENV['MISTRAL_API_KEY'] ?? null;
        $this->model  = $_ENV['MODEL'] ?? 'open-mistral-7b';

        if (!$this->apiKey) {
            throw new \Exception("Missing MISTRAL_API_KEY in .env");
        }
    }

    public function explain(string $code, string $language, $ast = null): string
    {

        $astText = $ast ? json_encode($ast, JSON_PRETTY_PRINT) : "No AST available.";


        $payload = [
        "model" => $this->model,
        "messages" => [
            [
                "role" => "system",
                "content" =>
                    "You are an expert software engineer. Use the AST to produce accurate explanations. " .
                    "If AST is present, prioritize structure over guessing."
            ],
            [
                "role" => "user",
                "content" =>
                    "Language: $language\n\n" .
                    "Code:\n$code\n\n" .
                    "AST:\n$astText\n\n" .
                    "Explain this code clearly. Include:\n" .
                    "- Purpose\n" .
                    "- How it works\n" .
                    "- Important operations\n" .
                    "- Potential errors\n" .
                    "- Time & space complexity\n"
            ]
        ]
    ];

        $curl = curl_init("https://api.mistral.ai/v1/chat/completions");

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Authorization: Bearer {$this->apiKey}"
            ],
            CURLOPT_POSTFIELDS => json_encode($payload)
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            return "Curl error: " . curl_error($curl);
        }

        curl_close($curl);

        $data = json_decode($response, true);

        // Debugging: Mistral error or unexpected response
        if (!$data) {
            return "Mistral API returned invalid JSON: " . $response;
        }

        if (isset($data['error'])) {
            return "Mistral API error: " . json_encode($data['error']);
        }

        if (!isset($data['choices'][0]['message']['content'])) {
            return "Mistral API returned unexpected structure: " . json_encode($data);
        }

        return $data['choices'][0]['message']['content'];
    }
}


?>