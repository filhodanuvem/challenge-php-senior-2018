<?php

namespace App\Service\Partner;

use App\Model\Predictions;
use App\Model\Prediction;
use App\Model\Temperature;

class PredictionsHydrator implements PredictionsHydratorInterface
{
    public function hydrate(array $data): Predictions
    {
        $predictions = new Predictions(
            $data['city'],
            $data['date']
        );

        foreach ($data['prediction'] as $predicitionData) {
            $predictions->addPrediction(
                new Prediction(
                    new Temperature($predicitionData['value']),
                    $predicitionData['time']
                )
            );
        }

        return $predictions;
    }
}
