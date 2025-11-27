<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Controllers\ExplainController;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '/explain' && $method === 'POST') {
    $controller = new ExplainController();
    $controller->explain();
    exit;
}

http_response_code(404);
echo json_encode(['error' => 'Route not found']);

?>