<?php

namespace App\Tests\Entity;

use App\Entity\WeatherData;
use PHPUnit\Framework\TestCase;

class WeatherDataTest extends TestCase
{
    public function dataGetFahrenheit(): array {
        return [
            ['0', 32],
            ['-100', -148],
            ['100', 212],
            ['0.5', 32.9],
            ['-40', -40],
            ['37', 98.6],
            ['20', 68],
            ['-17.78', 0],
            ['15.56', 60],
            ['26.67', 80],
        ];
    }

    /**
     * @dataProvider dataGetFahrenheit
     */
    public function testGetFahrenheit($celsius, $expectedFahrenheit): void {
        $measurement = new WeatherData();
        $measurement->setCelsius($celsius);
        $this->assertEquals($expectedFahrenheit, $measurement->getFahrenheit());
    }
}
