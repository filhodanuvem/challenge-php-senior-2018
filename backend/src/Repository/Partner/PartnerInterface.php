<?php

namespace App\Repository\Partner;

use App\Model\Predictions;

interface PartnerInterface
{
    public function fetchAllPredictions(string $city, \DateTime $date): Predictions;
}
