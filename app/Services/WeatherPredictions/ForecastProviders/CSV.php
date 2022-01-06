<?php

declare(strict_types=1);

namespace App\Services\WeatherPredictions\ForecastProviders;

use App\Services\WeatherPredictions\TemperatureConverter;
use App\Services\WeatherPredictions\ForecastProviders\DataTransferObjects\HourPrediction;
use App\Services\WeatherPredictions\TemperatureScales\TemperatureScale;
use DateTimeImmutable;
use App\Services\WeatherPredictions\ForecastProviders\DataTransferObjects\Prediction;
use Exception;

class CSV extends ForecastProvider
{
    /**
     * @throws Exception
     */
    public function getForecast(
        DateTimeImmutable $forecastDate,
        TemperatureScale $temperatureScale,
        TemperatureConverter $temperatureConverter,
    ): Prediction
    {
        $csv = array_map(
            'str_getcsv',
            file(public_path('ForecastProviderData/temps.csv'), FILE_SKIP_EMPTY_LINES)
        );
        $csvColumns = array_shift($csv);

        // Creating an associative array key => value for the csv data.
        foreach ($csv as $index => $row) {
            $csv[$index] = array_combine($csvColumns, $row);
        }

        // Parsing the pre-parsed csv data and creating DTO's
        $dayPredictions = array_shift($csv);

        $date = $dayPredictions['date'];

        // Parsing all the hourly predictions
        $hourPredictions = [];
        foreach ($csv as $hourPrediction) {
            $time = $this->createDateTimeImmutable(
                $date,
                $hourPrediction['prediction__time']
            );

            $convertedTemperature = $temperatureConverter->convert(
                temperature: (float) $hourPrediction['prediction__value'],
                from: $temperatureConverter->getScaleByName('Celcius'),
                to: $temperatureScale,
            );

            $hourPredictions[] = new HourPrediction(
                time: $time,
                temperature: $convertedTemperature,
            );
        }

        return new Prediction(
            date: $this->createDateTimeImmutable($date),
            hourPredictions: $hourPredictions,
        );
    }
}
