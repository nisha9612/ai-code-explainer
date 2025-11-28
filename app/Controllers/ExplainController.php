<?php

namespace App\Controllers;

use App\Services\GroqService;

class ExplainController
{
    public function explain()
    {
        header("Content-Type: application/json");

        // Read request body
        $input = json_decode(file_get_contents("php://input"), true);

        if (!$input) {
            echo json_encode(['error' => 'Invalid JSON']);
            exit;
        }

        $code = $input['code'] ?? null;
        $language = $input['language'] ?? 'unknown';
        $ast = $input['ast'] ?? null;

        if (!$code) {
            echo json_encode(['error' => 'Code is required']);
            exit;
        }

        try {
            $service = new GroqService();
            $result = $service->explain($code, $language, $ast);

            echo json_encode(['explanation' => $result]);
            exit;

        } catch (\Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }
}

?>