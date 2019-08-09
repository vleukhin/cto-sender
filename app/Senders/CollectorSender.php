<?php
/**
 * Created by Viktor Leukhin.
 * Tel: +7-926-797-5419
 * E-mail: vleukhin@ya.ru
 */

namespace App\Senders;

use App\Contracts\Sender;
use App\Lead;

class CollectorSender implements Sender
{
    /**
     * Collector service url
     *
     * @var string
     */
    protected $host;

    public function __construct($host)
    {
        $this->host = $host;
    }

    /**
     * Отправка лида
     *
     * @param Lead $lead
     *
     * @return array
     */
    public function send(Lead $lead): ?array
    {
        $url = $this->host . '/lead/create';

        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS     => http_build_query($lead->toArray()),
        ]);

        $result = curl_exec($ch);

        $result = @json_decode($result, true);

        if (empty($result)) {
            return null;
        }

        return $result;
    }

    /**
     * Получение имени отправщика
     *
     * @return string
     */
    public function getName()
    {
        return 'collector';
    }
}