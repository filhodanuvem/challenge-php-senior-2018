<?php

namespace App\Service\Converter;

use App\Model\Temperature;

class Fahrenheit implements ConverterInterface
{
    public function convertToCelsius(Temperature $temperature): Temperature
    {
        return new Temperature(
            ($temperature->getvalue() - 32) / 1.8
        );
    }

    public function convertFromCelsius(Temperature $temperature): Temperature
    {
        return new Temperature(
            $temperature->getvalue() * 1.8 + 32
        );
    }
}
