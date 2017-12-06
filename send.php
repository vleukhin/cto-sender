<?php

require 'vendor/autoload.php';

$dotenv = new Dotenv\Dotenv('./');
$dotenv->load();

$sender = new Sender(getenv('COLLECTOR_URL'));

print_r($_POST);

var_dump($geo->get_value(false, false));