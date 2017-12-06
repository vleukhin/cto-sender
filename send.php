<?php

require 'vendor/autoload.php';

$dotenv = new Dotenv\Dotenv('./');
$dotenv->load();

$lead = new \App\Lead($_POST['data']);

$manager = new \App\LeadsManager();
$manager->pushSender(new \App\Senders\CollectorSender(getenv('COLLECTOR_HOST')));
$manager->sendLead($lead);