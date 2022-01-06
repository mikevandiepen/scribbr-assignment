<?php

declare(strict_types=1);

namespace App\Services\WeatherPredictions\TemperatureScales;

class Celcius implements TemperatureScale
{
    /**
     * @inheritDoc
     */
    public function convertToKelvin(float $temperature): float
    {
        // Formula: [K] = [°C] + 273.15
        return $temperature + 273.15;
    }

    /**
     * @inheritDoc
     */
    public function convertFromKelvin(float $temperature): float
    {
        // Formula: [°C] = [K] − 273.15
        return $temperature - 273.15;
    }

    public function __toString(): string
    {
        return 'Celcius';
    }
}
