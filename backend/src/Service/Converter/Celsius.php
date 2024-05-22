<?php

namespace App\Service\Converter;

use App\Model\Temperature;

class Celsius implements ConverterInterface
{
    public function convertToCelsius(Temperature $temperature): Temperature
    {
        return $temperature;
    }

    public function convertFromCelsius(Temperature $temperature): Temperature
    {
        return $temperature;
    }
}
