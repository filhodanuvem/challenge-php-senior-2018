<?php

namespace App\Service\Partner;

use PHPUnit\Framework\TestCase;

class PredictionsHydratorTest extends TestCase
{   
    private $hydrator;

    public function setUp()
    {
        $this->hydrator = new PredictionsHydrator;
    }

    /**
     * @test
     */
    public function shouldReturnAnEmptyList()
    {
        $predictions =$this->hydrator->hydrate([
            "city" => "Amsterdam",
            "date" => "20180112",
            "prediction" => []
        ]);

        $this->assertCount(0, $predictions);
    }

    /**
     * @test
     */
    public function shouldReturnAValidPrediction()
    {
        $value = '6';
        $time = '10:00';
        $predictions = $this->hydrator->hydrate([
            "city" => "Amsterdam",
            "date" => "20180112",
            "prediction" => [
                [
                    'value' => $value,
                    'time' => $time,
                ]
            ]
        ]);

        $this->assertCount(1, $predictions);
        foreach ($predictions as $prediction) {
            $this->assertEquals($value, $prediction->getValue());
            $this->assertEquals($time, $prediction->getTime());
        }
    }
}
