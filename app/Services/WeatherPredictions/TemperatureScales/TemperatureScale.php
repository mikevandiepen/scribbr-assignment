<?php

declare(strict_types=1);

namespace App\Services\WeatherPredictions\TemperatureScales;

interface TemperatureScale
{
    public function __toString(): string;

    /**
     * @param float $temperature
     * @return float
     */
    public function convertToKelvin(float $temperature): float;

    /**
     * @param float $temperature
     * @return float
     */
    public function convertFromKelvin(float $temperature): float;
}
