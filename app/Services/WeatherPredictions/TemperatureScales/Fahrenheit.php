<?php

declare(strict_types=1);

namespace App\Services\WeatherPredictions\TemperatureScales;

class Fahrenheit implements TemperatureScale
{
    public function convertToKelvin(float $temperature): float
    {
        // Formula: [K] = ([°F] + 459.67) × 5⁄9
        return ($temperature + 459.67) * 5/9;
    }

    public function convertFromKelvin(float $temperature): float
    {
        // Formula: [°F] = [K] × 9⁄5 − 459.67
        return $temperature * 9/5 - 459.67;
    }

    public function __toString(): string
    {
        return 'Fahrenheit';
    }
}
