<?php
/**
 * Created by Viktor Leukhin.
 * Tel: +7-926-797-5419
 * E-mail: vleukhin@ya.ru
 */

namespace App\Senders;

use App\Contracts\Sender;
use App\Lead;

class EmailSender implements Sender
{

    /**
     * Отправка лида
     *
     * @param Lead $lead
     *
     * @return mixed
     */
    public function send(Lead $lead)
    {
        // TODO: Implement send() method.
    }

    /**
     * Получение имени отправщика
     *
     * @return string
     */
    public function getName()
    {
        return 'email';
    }
}