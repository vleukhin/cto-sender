<?php
/**
 * Created by Viktor Leukhin.
 * Tel: +7-926-797-5419
 * E-mail: vleukhin@ya.ru
 */

namespace App;


class UtmService
{
	protected $utms = [
		'utm_source' => 1,
		'utm_medium' => 1,
		'utm_campaign' => 1,
		'utm_term' => 1,
		'utm_content' => 1,
	];

	protected $query = [];

	public function __construct($referer)
	{
		$request = parse_url($referer);

		if (!empty($request['query']))
		{
			parse_str($request['query'], $this->query);
		}
	}

	public function getUtms()
	{
		return array_intersect_key($this->query, $this->utms);
	}
}