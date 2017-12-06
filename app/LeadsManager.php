<?php
/**
 * Created by Viktor Leukhin.
 * Tel: +7-926-797-5419
 * E-mail: vleukhin@ya.ru
 */

namespace App;

use App\Contracts\Sender;

class LeadsManager
{
    /**
     * @var Sender[]
     */
    protected $senders;

    public function __construct($senders = [])
    {
        $this->senders = $senders;
    }

    /**
     * Отправка лида по всем каналам
     *
     * @param Lead $lead
     */
    public function sendLead(Lead $lead)
    {
        foreach ($this->senders as $sender) {
            $sender->send($lead);
        }
    }

    /**
     * Добавление отправщика в стек
     *
     * @param Sender $sender
     */
    public function pushSender(Sender $sender)
    {
        $this->senders[] = $sender;
    }

    /**
     * Удаление отправщика из стека
     */
    public function popSender()
    {
        array_pop($this->senders[]);
    }
}