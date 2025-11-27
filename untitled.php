<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "API KEY = " . getenv('OPENAI_API_KEY') . PHP_EOL;
?>