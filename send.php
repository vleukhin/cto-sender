<?php

require 'vendor/autoload.php';

$dotenv = new Dotenv\Dotenv('./');
$dotenv->load();
$utm_service = new \App\UtmService();

$lead = new \App\Lead($_POST['data'] + $utm_service->getUtms());

$manager = new \App\LeadsManager();
$manager->pushSender(new \App\Senders\CollectorSender(getenv('COLLECTOR_HOST')));
$result = $manager->sendLead($lead);

header('Content-type: application/json');
echo json_encode(['result' => $result], JSON_PRETTY_PRINT);