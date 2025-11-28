<?php
namespace App\Services;

class GroqService {

    private string $apiKey;
    private string $model;

    public function __construct() {
        $this->apiKey = $_ENV["GROQ_API_KEY"] ?? "";
        $this->model  = $_ENV["MODEL"] ?? "llama-3.1-8b-instant";

        if (!$this->apiKey) {
            throw new \Exception("Missing GROQ_API_KEY");
        }
    }

    private function request(array $payload) {
        $ch = curl_init("https://api.groq.com/openai/v1/chat/completions");

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$this->apiKey}",
                "Content-Type: application/json"
            ],
            CURLOPT_POSTFIELDS => json_encode($payload)
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function explain(string $code, string $language, $ast = null): string {

        $astText = $ast
            ? json_encode($ast, JSON_PRETTY_PRINT)
            : "No AST available";

        $payload = [
            "model" => $this->model,
            "messages" => [
                [
                    "role" => "system",
                    "content" =>
                        "You're a senior engineer. Explain code using the AST structure when available."
                ],
                [
                    "role" => "user",
                    "content" =>
                        "Language: $language\n\nCode:\n$code\n\nAST:\n$astText\n\nExplain the code."
                ]
            ]
        ];

        $data = $this->request($payload);

        return $data["choices"][0]["message"]["content"]
            ?? "No explanation available.";
    }


    public function optimize(string $code, string $language): string {

        $payload = [
            "model" => $this->model,
            "messages" => [
                [
                    "role" => "system",
                    "content" =>
                        "Optimize the code for readability and best practices."
                ],
                [
                    "role" => "user",
                    "content" =>
                        "Language: $language\n\nOriginal Code:\n$code\n\nReturn ONLY the optimized code."
                ]
            ]
        ];

        $data = $this->request($payload);

        return $data["choices"][0]["message"]["content"]
            ?? "No optimized output.";
    }
}
