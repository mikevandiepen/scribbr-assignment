<?php

declare(strict_types=1);

namespace App\Services\WeatherPredictions\TemperatureScales;

class Romer implements TemperatureScale
{
    public function convertToKelvin(float $temperature): float
    {
        // Formula: [K] = ([°Rø] − 7.5) × 40⁄21 + 273.15
        return ($temperature - 7.5) * 40/21 + 273.15;
    }

    public function convertFromKelvin(float $temperature): float
    {
        // Formula: [°Rø] = ([K] − 273.15) × 21⁄40 + 7.5
        return ($temperature - 273.15) * 21/40 + 7.5;
    }

    public function __toString(): string
    {
        return 'Romer';
    }
}
