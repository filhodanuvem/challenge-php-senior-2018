<?php

namespace App\Repository\Partner;

use App\Service\Partner\PredictionsHydrator;
use App\Model\Predictions;

class BBC implements PartnerInterface
{
    const mockResponse = '{"predictions":{"-scale":"Fahrenheit","city":"Amsterdam","date":"20180112","prediction":[{"time":"00:00","value":"31"},{"time":"01:00","value":"32"},{"time":"02:00","value":"25"},{"time":"03:00","value":"26"},{"time":"04:00","value":"20"},{"time":"05:00","value":"22"},{"time":"06:00","value":"23"},{"time":"07:00","value":"22"},{"time":"08:00","value":"25"},{"time":"09:00","value":"24"},{"time":"10:00","value":"24"}]}}';
    private $hydrator;
    
    public function __construct(PredictionsHydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    public function fetchAllPredictions(string $city, \DateTime $date): Predictions
    {
        $responseArray = $this->findFromExternalService();
        
        if (!$responseArray || !isset($responseArray['predictions'])) {
            throw new \UnexpectedValueException;
        }

        return $this->hydrator->hydrate($responseArray['predictions']);
    }   

    private function findFromExternalService()
    {
        return json_decode(self::mockResponse, true);
    }
}
