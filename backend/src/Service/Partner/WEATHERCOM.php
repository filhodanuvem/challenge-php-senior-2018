<?php

namespace App\Service\Partner;

use App\Repository\Partner\WEATHERCOM as WEATHERCOMRepository;
use App\Model\Predictions;
use App\Model\Prediction;
use App\Model\Temperature;
use App\Service\Converter\Fahrenheit;

class WEATHERCOM implements PartnerInterface
{
    private $repository;

    public function __construct(WEATHERCOMRepository $repository)
    {
        $this->repository = $repository;
    }

    public function generatePredictions(string $city, \DateTime $date): Predictions
    {
        return $this->repository->fetchAllPredictions($city, $date);
    }
}
