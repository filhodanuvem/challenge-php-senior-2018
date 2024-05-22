<?php

namespace App\Service;

use App\Model\Predictions;
use App\Model\Prediction;
use App\Model\Temperature;

class AccuracyCalculator
{
    public function calculate(array $predicitionsList)
    {
        if (empty($predicitionsList)) {
            throw new \InvalidArgumentException();
        }

        $templatePrediction = $predicitionsList[0];
        $accuratePredictions = new Predictions(
            $templatePrediction->getCity(),
            $templatePrediction->getDate()
        );
        $numberOfPredicitionsList = count($predicitionsList);
        $numberOfPredictions = count($templatePrediction);

        for ($i = 0; $i < $numberOfPredictions; $i++) {
            $accurateValue = 0;
            $accurateTime;
            foreach ($predicitionsList as $predicitions) {
                $accurateValue += $predicitions->current()->getValue();
                $accurateTime = $predicitions->current()->getTime();
                $predicitions->next();
            }

            $accuratePredictions->addPrediction(
                new Prediction(
                    new Temperature($accurateValue/$numberOfPredicitionsList),
                    $accurateTime   
                )
            );

        }

        return $accuratePredictions;
    }
}
