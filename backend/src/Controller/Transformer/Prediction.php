<?php

namespace App\Controller\Transformer;

use App\Model\Prediction as PredictionModel;
use App\Service\Converter\ConverterInterface;

class Prediction
{
    private $converters = [];
    
    public function transform(PredictionModel $prediction)
    {
        return [
            'time' => $prediction->getTime(),
            'temperature' => $this->getConvertedTemperatures($prediction),
        ];
    }

    private function getConvertedTemperatures(PredictionModel $prediction)
    {
        $convertedTemperatures = [];
        foreach ($this->converters as $name => $converter) {
            $convertedTemperatures[$name] = $converter->convertFromCelsius($prediction->getTemperature())->getValue();
        }

        return $convertedTemperatures;
    }

    public function addScaleConverter(string $name, ConverterInterface $converter)
    {
        $this->converters[$name] = $converter;
    }
}
