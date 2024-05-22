<?php

namespace App\Service\Partner;

use App\Repository\Partner\BBC as BBCRepository;
use App\Model\Predictions;
use App\Model\Prediction;
use App\Model\Temperature;
use App\Service\Converter\Fahrenheit;

class BBC implements PartnerInterface
{
    private $repository;
    private $scaleConverter;

    public function __construct(BBCRepository $repository, Fahrenheit $scaleConverter)
    {
        $this->repository = $repository;
        $this->scaleConverter = $scaleConverter;
    }

    public function generatePredictions(string $city, \DateTime $date): Predictions
    {
        $predictionsInFahrenheit = $this->repository->fetchAllPredictions($city, $date);
        $predictionsInCelsius = new Predictions(
            $predictionsInFahrenheit->getCity(),
            $predictionsInFahrenheit->getDate()
        );
        
        foreach ($predictionsInFahrenheit as $prediction) {
            $predictionsInCelsius->addPrediction(
                new Prediction(
                    $this->scaleConverter->convertToCelsius($prediction->getTemperature()),
                    $prediction->getTime()
                )
            );
        }

        return $predictionsInCelsius;
    }
}
