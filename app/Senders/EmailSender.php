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
     * С какой почты отправлять
     *
     * @var string
     */
    protected $email_from;

    /**
     * На какую почту отправлять
     *
     * @var string
     */
    protected $email_to;

    /**
     * Тема письма
     *
     * @var string
     */
    protected $subject;

    /**
     * Имя отправителя
     *
     * @var string
     */
    protected $name;

    public function __construct($email_from, $email_to, $name, $subject)
    {
        $this->email_from = $email_from;
        $this->email_to = $email_to;
        $this->subject = $subject;
        $this->name = $name;
    }

    /**
     * Отправка лида
     *
     * @param Lead $lead
     *
     * @return bool
     */
    public function send(Lead $lead)
    {
        $text = $lead->toString();
        
        $headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=utf-8\r\n";
        $headers .= "From: =?UTF-8?B?" . base64_encode($this->name) . "?= <" . $this->email_from . ">\r\n";

        return mail($this->email_to, "=?UTF-8?B?" . base64_encode($this->subject) . "?=", $text, $headers);
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