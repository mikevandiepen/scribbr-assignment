<?php

declare(strict_types=1);

namespace App\Services\WeatherPredictions\TemperatureScales;

class Rankine implements TemperatureScale
{
    public function convertToKelvin(float $temperature): float
    {
        // Formula: [K] = [°R] × 5⁄9
        return $temperature * 5/9;
    }

    public function convertFromKelvin(float $temperature): float
    {
        // Formula: [°R] = [K] × 9⁄5
        return $temperature * 9/5;
    }

    public function __toString(): string
    {
        return 'Rankine';
    }
}
