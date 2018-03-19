<?php

require 'vendor/autoload.php';

$service = new \App\CurrencyService();
$rates = $service->getRates(['USD', 'EUR'])->to('RUB')->fromCBRF();

function convert_currency($amount, $from)
{
	global $rates;

	return number_format($amount * $rates[$from]['RUB'], 0);
}