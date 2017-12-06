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

    public function toArray()
    {
        return $this->attributes;
    }
}