<?php

namespace App\Model;

class Prediction implements \JsonSerializable
{
    private $temperature;
    private $time;

    public function __construct(Temperature $temperature, string $time)
    {
        $this->temperature = $temperature;
        $this->time = $time;
    }

    public function getTemperature()
    {
        return $this->temperature;
    }

    public function getValue()
    {
        return $this->temperature->getValue();
    }

    public function getTime()
    {
        return $this->time;
    }

    public function  jsonSerialize()
    {
        return [
            'temperature' => $this->getValue(),
            'time' => $this->getTime(),
        ];
    }
}
