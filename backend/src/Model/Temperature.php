<?php

namespace App\Model;

class Temperature
{
    private $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}
