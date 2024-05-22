<?php

namespace App\Service;

use PHPUnit\Framework\TestCase;
use App\Model\Predictions;
use App\Model\Prediction;
use App\Model\Temperature;

class AccuracyCalculatorTest extends TestCase
{   
    private $calculator;

    public function setUp()
    {
        $this->calculator = new AccuracyCalculator;
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function shouldThrowErrorWhenThereIsNoParterAssociated()
    {
        $allPredictions = [];
        $predictions = $this->calculator->calculate($allPredictions);

        $this->assertEmpty($predictions);
    }

    /**
     * @test
     */
    public function shouldReturnTheSamePredictionsIfThereIsOnlyOnePartner()
    {
        $predictionsA = new Predictions("Juiz de Fora", "2018-03-10");
        $predictionsA->addPrediction(new Prediction(new Temperature(-2), "06:00"));
        $predictionsA->addPrediction(new Prediction(new Temperature(8), "09:00"));
        $predictionsA->addPrediction(new Prediction(new Temperature(9), "09:00"));
        $expectPredictions = clone $predictionsA;
        $allPredictions = [$predictionsA];
        
        $predictions = $this->calculator->calculate($allPredictions);
        $this->assertPredictions(
            $expectPredictions,
            $predictions
        );
    }

    /**
     * @test
     */
    public function shouldReturnTheSamePredictionsIfThereIsTwoPartnersWithTheSameValues()
    {
        $predictionsA = new Predictions("Juiz de Fora", "2018-03-10");
        $predictionsA->addPrediction(new Prediction(new Temperature(-2), "06:00"));
        $predictionsA->addPrediction(new Prediction(new Temperature(8), "09:00"));
        $predictionsA->addPrediction(new Prediction(new Temperature(9), "09:00"));
        $predictionsB = clone $predictionsA;
        $expectPredictions = clone $predictionsA;
        $allPredictions = [$predictionsA, $predictionsB];
        
        $predictions = $this->calculator->calculate($allPredictions);
        $this->assertPredictions(
            $expectPredictions,
            $predictions
        );
    }

    /**
     * @test
     */
    public function shouldReturnTheAverageValuesBetweenDifferentPartnerPredictions()
    {
        $predictionsA = new Predictions("Juiz de Fora", "2018-03-10");
        $predictionsA->addPrediction(new Prediction(new Temperature(-2), "06:00"));
        $predictionsA->addPrediction(new Prediction(new Temperature(8), "09:00"));
        $predictionsA->addPrediction(new Prediction(new Temperature(9), "09:00"));
        
        $predictionsB = new Predictions("Juiz de Fora", "2018-03-10");
        $predictionsB->addPrediction(new Prediction(new Temperature(6), "06:00"));
        $predictionsB->addPrediction(new Prediction(new Temperature(8), "09:00"));
        $predictionsB->addPrediction(new Prediction(new Temperature(11), "09:00"));
        
        $expectedPredictions = new Predictions("Juiz de Fora", "2018-03-10");
        $expectedPredictions->addPrediction(new Prediction(new Temperature(2), "06:00"));
        $expectedPredictions->addPrediction(new Prediction(new Temperature(8), "09:00"));
        $expectedPredictions->addPrediction(new Prediction(new Temperature(10), "09:00"));

        $allPredictions = [$predictionsA, $predictionsB];
        
        $predictions = $this->calculator->calculate($allPredictions);
        $this->assertPredictions(
            $expectedPredictions,
            $predictions
        );
    }

    private function assertPredictions(Predictions $expectedPredictions, Predictions $foundPredictions)
    {
        if (count($expectedPredictions) != count($foundPredictions)) {
            $this->fail(sprintf("Predictions have different number of values (%d, %d)", count($expectedPredictions), count($foundPredictions)));
        }

        foreach ($foundPredictions as $key => $prediction) {
            $this->assertEquals(
                $expectedPredictions->current()->getValue(),
                $prediction->getValue()
            );

            $expectedPredictions->next();
        }
    }
}
