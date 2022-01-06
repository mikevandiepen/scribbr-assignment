<?php

declare(strict_types=1);

namespace App\Services\WeatherPredictions\ForecastProviders\DataTransferObjects;

use DateTimeImmutable;

class Prediction
{
    /**
     * @param DateTimeImmutable $date
     * @param Hourprediction[] $hourPredictions
     */
    public function __construct(
        private DateTimeImmutable $date,
        private array $hourPredictions,
    ) {}

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return Hourprediction[]
     */
    public function getHourPredictions(): array
    {
        return $this->hourPredictions;
    }
}
