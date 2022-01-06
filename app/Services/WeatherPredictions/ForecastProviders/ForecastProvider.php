<?php

declare(strict_types=1);

namespace App\Services\WeatherPredictions\ForecastProviders;

use App\Services\WeatherPredictions\TemperatureConverter;
use App\Services\WeatherPredictions\TemperatureScales\TemperatureScale;
use DateTimeImmutable;
use App\Services\WeatherPredictions\ForecastProviders\DataTransferObjects\Prediction;
use Exception;

abstract class ForecastProvider
{
    abstract public function getForecast(
        DateTimeImmutable $forecastDate,
        TemperatureScale $temperatureScale,
        TemperatureConverter $temperatureConverter,
    ): Prediction;

    /**
     * Datetime pattern should be ISO 8601 but the sample data provided isn't.
     *
     * @param string $date
     * @param string|null $time
     * @return DateTimeImmutable
     * @throws Exception
     */
    protected function createDateTimeImmutable(
        string $date,
        ?string $time = null,
    ): DateTimeImmutable
    {
        if ($time !== null) {
            $datetime = $date . ' ' . $time . ':00';
        } else {
            $datetime = $date;
        }

        return new DateTimeImmutable($datetime);
    }
}
