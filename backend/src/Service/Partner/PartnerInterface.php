<?php

namespace App\Service\Partner;

use App\Model\Predictions;

interface PartnerInterface
{
    public function generatePredictions(string $city, \DateTime $date): Predictions;
}
