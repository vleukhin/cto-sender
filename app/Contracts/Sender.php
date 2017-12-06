<?php
/**
 * Created by Viktor Leukhin.
 * Tel: +7-926-797-5419
 * E-mail: vleukhin@ya.ru
 */

namespace App\Contracts;

use App\Lead;

interface Sender
{
    /**
     * Отправка лида
     *
     * @param Lead $lead
     *
     * @return mixed
     */
    public function send(Lead $lead);
}