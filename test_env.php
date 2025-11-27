<?php
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "_ENV:   " . var_export($_ENV['MISTRAL_API_KEY'] ?? null, true) . PHP_EOL;

echo "_ENV:   " . ($_ENV['MISTRAL_API_KEY'] ?? 'NOT FOUND') . PHP_EOL;
?>