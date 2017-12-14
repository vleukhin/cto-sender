<?php
/**
 * Created by Viktor Leukhin.
 * Tel: +7-926-797-5419
 * E-mail: vleukhin@ya.ru
 */

namespace App;

class Lead
{
    /**
     * @var array
     */
    protected $attributes;

    public function __construct($attributes)
    {
        $attributes['group_id'] = getenv('GROUP_ID');
        $attributes['source'] = getenv('SOURCE');

        $this->attributes = $attributes;
    }

    /**
     * Параметры лида в виде массива
     *
     * @return array
     */
    public function toArray()
    {
        return $this->attributes;
    }

    /**
     * Текстовое представление лида
     *
     * @return string
     */
    public function toString()
    {
        $text = "
<p><strong>Форма:</strong> {$this->comment}</p>
<p><strong>Имя:</strong> {$this->name}</p>
<p><strong>Телефон:</strong> {$this->phone}</p>
<p><strong>E-mail:</strong>{$this->email}</p>
<hr><br><br>
<p><strong>ГЕО<br>Город через Яндекс:</strong> {$this->city}</p>
<p><strong>UTM:</strong><br>
 Источник (utm_source): {$this->utm_source}<br>
Тип рекламы (utm_medium): {$this->utm_medium}<br>
Кампания (utm_campaign): {$this->utm_campaign}<br>
Запрос (utm_term): {$this->utm_term}<br>
</p>";

        return $text;
    }

    public function __get($name)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }
}