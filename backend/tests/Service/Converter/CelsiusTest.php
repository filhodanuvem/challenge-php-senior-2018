<?php

namespace App\Service\Converter;

use App\Model\Temperature;
use PHPUnit\Framework\TestCase;

class CelsiusTest extends TestCase
{   
    private $celsius;

    public function setUp()
    {
        $this->celsius = new Celsius;
    }

    /**
     * @test
     */
    public function shouldNotChangeTheEntity()
    {
        $temperature = new Temperature(24);

        $this->assertSame(
            $temperature,
            $this->celsius->convertToCelsius($temperature)
        );
    }
}
