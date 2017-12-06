<?php

require 'vendor/autoload.php';

$dotenv = new Dotenv\Dotenv('./');
$dotenv->load();

echo getenv('COLLECTOR_URL');