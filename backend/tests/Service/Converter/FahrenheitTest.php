<?php

namespace App\Service\Converter;

use App\Model\Temperature;
use PHPUnit\Framework\TestCase;

class FahrenheitTest extends TestCase
{
    private $fahrenheit;

    public function setUp()
    {
        $this->fahrenheit = new Fahrenheit();
    }

    /**
     * @test
     * @dataProvider fromCelsiusToFahrenheit
     */
    public function shouldNotChangeTheEntity($celsiusValue, $fahrenheitValue)
    {
        $temperature = new Temperature($fahrenheitValue);
        $convertedTemperature = $this->fahrenheit->convertToCelsius($temperature);

        $this->assertEquals(
            $celsiusValue,
            $convertedTemperature->getValue()
        );
    }

    public function fromCelsiusToFahrenheit()
    {
        return [
            [0, 32],
            [1, 33.8],
            [-10, 14],
            [40, 104]
        ];
    }
}
