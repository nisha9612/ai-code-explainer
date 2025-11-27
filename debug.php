<?php

echo "CURRENT FILE: " . __FILE__ . PHP_EOL;
echo "CURRENT DIR:  " . __DIR__ . PHP_EOL;
echo "PWD:          " . getcwd() . PHP_EOL;
echo "FILES IN __DIR__:" . PHP_EOL;
print_r(scandir(__DIR__));

echo "\nTrying to load dotenv...\n";

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "\nENV:\n";
var_dump($_ENV);
var_dump(getenv('MISTRAL_API_KEY'));
?>