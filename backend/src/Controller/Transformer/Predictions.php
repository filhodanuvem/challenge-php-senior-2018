<?php

namespace App\Controller\Transformer;

use App\Model\Predictions as PredictionsModel;

class Predictions
{
    private $predictionTransformer;

    public function __construct(Prediction $prediction)
    {
        $this->predictionTransformer = $prediction;
    }

    public function transform(PredictionsModel $predictions)
    {
        $predictionsTransfer = [];
        foreach ($predictions as $prediction) {
            $predictionsTransfer[] = $this->predictionTransformer->transform($prediction);
        }

        return $predictionsTransfer;
    }
}
