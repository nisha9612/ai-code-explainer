<?php

namespace App\Services;

class MistralService
{
    private string $apiKey;
    private string $model;

    public function __construct()
    {
        // Use $_ENV because macOS Herd blocks getenv()
        $this->apiKey = $_ENV['OPENAI_API_KEY'] ?? null;
        $this->model  = $_ENV['MODEL'] ?? 'mistral-small-latest';

        if (!$this->apiKey) {
            throw new \Exception("Missing MISTRAL_API_KEY in .env");
        }
    }

    public function explain(string $code, string $language): string
    {
        $payload = [
            "model" => $this->model,
            "messages" => [
                ["role" => "system", "content" => "You are an expert software engineer. Explain code very clearly."],
                ["role" => "user", "content" => "Explain the following $language code:\n\n$code"]
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
            throw new \Exception("Curl error: " . curl_error($curl));
        }

        curl_close($curl);

        $data = json_decode($response, true);

        if (isset($data['error'])) {
            return json_encode(["error" => $data['error']['message']]);
        }

        return $data['choices'][0]['message']['content'] ?? "No explanation available.";
    }
}

?>