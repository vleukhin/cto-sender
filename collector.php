<?php

require 'vendor/autoload.php';

$dotenv = new Dotenv\Dotenv('./');
$dotenv->load();

header('Content-type: application/json');

echo json_encode([
    'url' => getenv('COLLECTOR_HOST'),
], JSON_PRETTY_PRINT);