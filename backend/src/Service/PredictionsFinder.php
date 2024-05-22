<?php

namespace App\Service;

use App\Service\Partner\PartnerInterface;
use App\Service\AccuracyCalculator;

class PredictionsFinder
{
    private $partners = [];
    private $calculator;

    public function __construct(AccuracyCalculator $calculator)
    {
        $this->calculator = $calculator;
    }

    public function findPredictions(string $city, \DateTime $date)
    {
        $predictionsList = [];
        foreach ($this->partners as $partner) {
            $predictionsList[] = $partner->generatePredictions($city, $date);
        }

        return $this->calculator->calculate($predictionsList);
    }

    public function addPartner(PartnerInterface $partner)
    {
        $this->partners[] = $partner;
    }
}
