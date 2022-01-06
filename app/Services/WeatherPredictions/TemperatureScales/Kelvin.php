<?php

declare(strict_types=1);

namespace App\Services\WeatherPredictions\TemperatureScales;

/**
 * This class is non-applicable since every temperature can be converted from and to kelvin.
 * We apply it anyway co cohere to the adapter pattern.
 */
class Kelvin implements TemperatureScale
{
    public function convertToKelvin(float $temperature): float
    {
        return $temperature;
    }

    public function convertFromKelvin(float $temperature): float
    {
        return $temperature;
    }

    public function __toString(): string
    {
        return 'Kelvin';
    }
}
