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
     * @return bool
     */
    public function send(Lead $lead);

    /**
     * Получение имени отправщика
     *
     * @return string
     */
    public function getName();
}