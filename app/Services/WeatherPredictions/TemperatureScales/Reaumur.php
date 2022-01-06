<?php

declare(strict_types=1);

namespace App\Services\WeatherPredictions\TemperatureScales;

class Reaumur implements TemperatureScale
{
    public function convertToKelvin(float $temperature): float
    {
        // Formula: [K] = [°Ré] × 5⁄4 + 273.15
        return $temperature * 5/4 + 273.15;
    }

    public function convertFromKelvin(float $temperature): float
    {
        // Formula: [°Ré] = ([K] − 273.15) × 4⁄5
        return ($temperature - 273.15) * 4/5;
    }

    public function __toString(): string
    {
        return 'Reaumur';
    }
}
