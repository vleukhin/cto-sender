<?php
/**
 * Created by Viktor Leukhin.
 * Tel: +7-926-797-5419
 * E-mail: vleukhin@ya.ru
 */

namespace App;

use SimpleXMLElement;

class CurrencyService
{
	/**
	 * Список валют для которых получать курсы
	 *
	 * @var array
	 */
	protected $currencies = [];

	/**
	 * Список валют по отношению к которым будут получены курсы
	 *
	 * @var array
	 */
	protected $to = [];

	/**
	 * Указание курсы каких валют нужно получить
	 *
	 * @param string[]|array ...$currencies
	 *
	 * @return $this
	 */
	public function getRates(...$currencies): CurrencyService
	{
		if (!empty($currencies[0]) and is_array($currencies[0])) {
			$currencies = $currencies[0];
		}

		foreach ($currencies as $currency) {
			$this->currencies[] = strtoupper($currency);
		}

		return $this;
	}

	/**
	 * К каким валютам нужно получать крусы
	 *
	 * @param string[]|array ...$currencies
	 *
	 * @return $this
	 */
	public function to(...$currencies): CurrencyService
	{
		if (!empty($currencies[0]) and is_array($currencies[0])) {
			$currencies = $currencies[0];
		}

		foreach ($currencies as $currency) {
			$this->to[] = strtoupper($currency);
		}

		return $this;
	}

	/**
	 * Получение курсов валют от ЕЦБ
	 *
	 * @return array|null
	 */
	public function fromECB(): ?array
	{
		$rates = [];

		$params = [
			'symbols' => implode(',', $this->getCurrenciesList()),
		];

		$url = 'http://api.fixer.io/latest';

		try {
			$response = json_decode($this->getUrl($url, $params));

			foreach ($this->currencies as $currency) {
				foreach ($this->to as $targetCurrency) {
					if ($currency === 'EUR') {
						$rates[$currency][$targetCurrency] = !empty($response->rates->{$targetCurrency}) ? $response->rates->{$targetCurrency} : (float)1;
					} else {
						$targetCurrencyRate = !empty($response->rates->{$targetCurrency}) ? $response->rates->{$targetCurrency} : 1;
						if (!empty($response->rates->{$currency})) {
							$rates[$currency][$targetCurrency] = $targetCurrencyRate / $response->rates->{$currency};
						} else {
							$rates[$currency][$targetCurrency] = -1;
						}
					}
				}
			}

			return $rates;
		} catch (\Exception $e) {
			return null;
		}
	}

	/**
	 * Получение курсов валют от ЦБРФ
	 *
	 * @return array|null
	 */
	public function fromCBRF(): ?array
	{
		$rates = [];
		$params = [];

		$response = $this->getUrl('http://www.cbr.ru/scripts/XML_daily.asp', $params);


		try {
			$xml = new SimpleXMLElement($response);
		} catch (\Exception $e) {

		}

		if (isset($xml)) {
			foreach ($this->currencies as $currency) {
				foreach ($this->to as $targetCurrency) {
					$targetRate = $this->getCBRFCurrencyRate($xml, $targetCurrency);

					if ($currency === 'RUB') {
						$rates[$currency][$targetCurrency] = 1 / $targetRate;
					} else {
						$rate = $this->getCBRFCurrencyRate($xml, $currency);
						$rates[$currency][$targetCurrency] = 1 / ($targetRate / $rate);
					}
				}
			}
		}

		return !empty($rates) ? $rates : null;
	}

	/**
	 * Получение курса валюты из xml от ЦБРФ
	 *
	 * @param SimpleXMLElement $xml
	 * @param string           $currency
	 *
	 * @return float
	 */
	protected function getCBRFCurrencyRate(SimpleXMLElement $xml, string $currency): float
	{
		$valute = $xml->xpath('/ValCurs/Valute[CharCode="' . $currency . '"]');

		if (!empty($valute)) {
			$valute = $valute[0];
			return (float)str_replace(',', '.', $valute->Value) / (int)$valute->Nominal;
		}

		return (float)1;
	}

	/**
	 * Получает список всех валют, по которым нужна информация
	 *
	 * @return array
	 */
	protected function getCurrenciesList(): array
	{
		return array_merge($this->currencies, $this->to);
	}

	/**
	 * GET запрос на указаный URL
	 *
	 * @param string $url
	 * @param array  $query
	 *
	 * @return string|null
	 */
	protected function getUrl(string $url, array $query): ?string
	{
		$result = @file_get_contents($url . '?' . http_build_query($query));

		if ($result === false) {
			return null;
		}

		return $result;
	}
}