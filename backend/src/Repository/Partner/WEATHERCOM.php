<?php

namespace App\Repository\Partner;

use App\Service\Partner\PredictionsHydrator;
use App\Model\Predictions;
use App\Model\Prediction;
use App\Model\Temperature;

class WEATHERCOM implements PartnerInterface
{
    const mockResponse = '<?xml version="1.0" encoding="utf-8" ?><predictions scale="celsius"><city>Amsterdam</city><date>20180112</date><prediction><time>00:00</time><value>05</value></prediction><prediction><time>01:00</time><value>05</value></prediction><prediction><time>02:00</time><value>06</value></prediction><prediction><time>03:00</time><value>05</value></prediction><prediction><time>04:00</time><value>08</value></prediction><prediction><time>05:00</time><value>05</value></prediction><prediction><time>06:00</time><value>15</value></prediction><prediction><time>07:00</time><value>00</value></prediction><prediction><time>08:00</time><value>01</value></prediction><prediction><time>09:00</time><value>02</value></prediction><prediction><time>10:00</time><value>03</value></prediction></predictions>';

    public function fetchAllPredictions(string $city, \DateTime $date): Predictions
    {
        $responseArray = $this->findFromExternalService();
        
        if (!$responseArray) {
            throw new \UnexpectedValueException;
        }

        return $this->hydrate($responseArray);
    }   

    private function findFromExternalService()
    {
        return new \SimpleXMLElement(self::mockResponse);
    }

    private function hydrate($data)
    {
       $predictions =  new Predictions(
            $data->city,
            $data->date
       );
       
       foreach ($data->prediction as $prediction) {
            $predictions->addPrediction(
                new Prediction(
                    new Temperature((float)$prediction->value),
                    (string)$prediction->time
                )
            );
       }
       
       return $predictions;
    }
}
