<?php

namespace App\Service\Partner;

use App\Model\Predictions;

interface PredictionsHydratorInterface
{
    public function hydrate(array $data): Predictions;
}
