<?php

require 'vendor/autoload.php';

$dotenv = new Dotenv\Dotenv('./');
$dotenv->load();

echo getenv('COLLECTOR_URL');

print_r($POST);

$geo = new \App\Geo([
    'id'      => $_SERVER['REMOTE_ADDR'],
    'charset' => 'utf-8',
]);

var_dump($geo->get_value(false, false));