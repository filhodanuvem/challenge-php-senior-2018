<?php

namespace App\Service\Converter;

use App\Model\Temperature;

interface ConverterInterface
{
    public function convertToCelsius(Temperature $temperature): Temperature;
    public function convertFromCelsius(Temperature $temperature): Temperature;
}
