<?php

declare(strict_types=1);

namespace App\Services\WeatherPredictions\ForecastProviders\DataTransferObjects;

use DateTimeImmutable;

class HourPrediction
{
    public function __construct(
        private DateTimeImmutable $time,
        private float $temperature,
    ) {}

    /**
     * @return DateTimeImmutable
     */
    public function getTime(): DateTimeImmutable
    {
        return $this->time;
    }

    /**
     * @return float
     */
    public function getTemperature(): float
    {
        return $this->temperature;
    }
}