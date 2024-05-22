<?php

namespace App\Service\Partner;

use App\Repository\Partner\BBC as BBCRepository;
use App\Model\Predictions;
use App\Model\Prediction;
use App\Model\temperature;
use App\Service\Converter\Fahrenheit;
use PHPUnit\Framework\TestCase;

class BBCTest extends TestCase
{
    private $repository;
    private $converter;
    private $service;

    public function setUp()
    {
        $this->repository = $this->getmockBuilder(BBCRepository::class)
            ->disableOriginalConstructor()
            ->getmock();
        $this->converter = $this->getmockBuilder(Fahrenheit::class)
            ->disableOriginalConstructor()
            ->getmock();
            

        $this->service = new BBC($this->repository, $this->converter);
    }

    /**
     * @test
     */
    public function shouldReturnValuesInCelsius()
    {
        $predictionsA = new Predictions("Lisboa", "2018-03-10");
        $predictionsA->addPrediction(new Prediction(new Temperature(0), "06:00"));
        $predictionsA->addPrediction(new Prediction(new Temperature(1), "09:00"));
        $predictionsA->addPrediction(new Prediction(new Temperature(-10), "09:00"));

        $this->repository->method('fetchAllPredictions')->willReturn($predictionsA);
        $this->converter->method('convertToCelsius')->will($this->returnCallback(function($temperatureA) {
            return new Temperature(
                $temperatureA->getValue() + 1
            );
        }));

        $predictions = $this->service->generatePredictions("Lisboa", new \DateTime("2018-03-10"));

        $this->assertEquals(1, $predictions->current()->getValue());
        $predictions->next();
        $this->assertEquals(2, $predictions->current()->getValue());
        $predictions->next();
        $this->assertEquals(-9, $predictions->current()->getValue());
    }
}
