<?php

declare(strict_types=1);

namespace App\Services\WeatherPredictions\TemperatureScales;

class Newton implements TemperatureScale
{
    public function convertToKelvin(float $temperature): float
    {
        // Formula: [K] = [°N] × 100⁄33 + 273.15
        return $temperature * 100/33 + 273.15;
    }

    public function convertFromKelvin(float $temperature): float
    {
        // Formula: [°N] = ([K] − 273.15) × 33⁄100
        return ($temperature - 273.15) * 33/100;
    }

    public function __toString(): string
    {
        return 'Newton';
    }
}
