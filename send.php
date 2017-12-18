<?php

use App\Lead;
use App\LeadsManager;
use App\Senders\CollectorSender;
use App\Senders\EmailSender;
use App\UtmService;

require 'vendor/autoload.php';

$logger = new \Monolog\Logger('app', [
    new \Monolog\Handler\RotatingFileHandler('./storage/logs/app.log'),
]);

$dotenv = new Dotenv\Dotenv('./');
$dotenv->load();
$utm_service = new UtmService();

$attr = $_POST + $utm_service->getUtms();

$lead = new Lead($attr);

if (!empty($_POST['message'])) {
    $logger = new \Monolog\Logger('app', [
        new \Monolog\Handler\RotatingFileHandler('./storage/logs/js.log'),
    ]);

    $logger->debug('post', $_POST);
    $logger->debug('server', $_SERVER);
    echo 'logged';
    exit;
}

$logger->debug('post', $_POST);
$logger->debug('server', $_SERVER);
$logger->debug('get', $_GET);
$logger->info('lead', $attr);


if ($lead->phone) {
    $manager = new LeadsManager();
    $manager->pushSender(new EmailSender(getenv('EMAIL_FROM'), getenv('EMAIL_TO'), getenv('EMAIL_NAME'), getenv('EMAIL_SUBJECT')));
    $manager->pushSender(new CollectorSender(getenv('COLLECTOR_HOST')));
    $result = $manager->sendLead($lead);
} else {
    $result = false;
}


header('Content-type: application/json');
echo json_encode(['result' => $result], JSON_PRETTY_PRINT);