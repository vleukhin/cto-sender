<?php

$file = __DIR__ . '/storage/rates.json';

$now = time();

$service = new \App\CurrencyService();
if (file_exists($file)) {
	$GLOBALS['rates'] = @json_decode(file_get_contents($file), true);

	if (empty($GLOBALS['rates']['expired']) or $GLOBALS['rates']['expired'] < $now) {
		unlink($file);
		unset($GLOBALS['rates']);
	}
}


if (empty($GLOBALS['rates'])) {
	$GLOBALS['rates'] = $service->getRates(['USD', 'EUR'])
		->to('RUB')
		->fromCBRF();

	$GLOBALS['rates']['expired'] = strtotime('tomorrow', $now) - 1;

	file_put_contents($file, json_encode($GLOBALS['rates']));
}

function convert_currency($amount, $from)
{
	return number_format($amount * $GLOBALS['rates'][$from]['RUB'], 0, ',', '');
}