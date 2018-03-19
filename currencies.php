<?php

require 'vendor/autoload.php';

$file = __DIR__ . '/storage/rates.json';

$now = time();

$service = new \App\CurrencyService();
if (file_exists($file)) {
	$rates = @json_decode(file_get_contents($file), true);

	if (empty($rates['expired']) or $rates['expired'] < $now) {
		unlink($file);
		unset($rates);
	}
}


if (empty($rates)) {
	$rates = $service->getRates(['USD', 'EUR'])
		->to('RUB')
		->fromCBRF();

	$rates['expired'] = strtotime('tomorrow', $now) - 1;

	file_put_contents($file, json_encode($rates));
}

function convert_currency($amount, $from)
{
	global $rates;

	return number_format($amount * $rates[$from]['RUB'], 0, ',', '');
}