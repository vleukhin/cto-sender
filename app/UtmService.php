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
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
    ];

    public function getUtms()
    {
        $result = [];

        foreach ($this->utms as $utm) {
            if (isset($_COOKIE['cookie_' . $utm])) {
                $result[$utm] = $_COOKIE['cookie_' . $utm];
            }
        }

        return $result;
    }
}