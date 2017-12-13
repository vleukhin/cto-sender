<?php

use App\Lead;
use App\LeadsManager;
use App\Senders\CollectorSender;
use App\Senders\EmailSender;
use App\UtmService;

require 'vendor/autoload.php';

$dotenv = new Dotenv\Dotenv('./');
$dotenv->load();
$utm_service = new UtmService();

$lead = new Lead($_POST + $utm_service->getUtms());

$manager = new LeadsManager();
$manager->pushSender(new EmailSender(getenv('EMAIL_FROM'), getenv('EMAIL_TO'), getenv('EMAIL_NAME'), getenv('EMAIL_SUBJECT')));

if ($lead->name == 'Виктор тест') {
    $manager->pushSender(new CollectorSender(getenv('COLLECTOR_HOST')));
}

$result = $manager->sendLead($lead);

header('Content-type: application/json');
echo json_encode(['result' => $result], JSON_PRETTY_PRINT);