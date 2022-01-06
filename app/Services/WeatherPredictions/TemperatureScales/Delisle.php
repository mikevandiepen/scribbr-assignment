<?php

declare(strict_types=1);

namespace App\Services\WeatherPredictions\TemperatureScales;

class Delisle implements TemperatureScale
{
    public function convertToKelvin(float $temperature): float
    {
        // Formula: [K] = 373.15 − [°De] × 2⁄3
        return 373.15 - $temperature * 2/3;
    }

    public function convertFromKelvin(float $temperature): float
    {
        // Formula: [°De] = (373.15 − [K]) × 3⁄2
        return (373.15 - $temperature) * 3/2;
    }

    public function __toString(): string
    {
        return 'Delisle';
    }
}
