<?php

declare(strict_types=1);

namespace App\Services\WeatherPredictions\ForecastProviders;

use App\Services\WeatherPredictions\TemperatureConverter;
use App\Services\WeatherPredictions\TemperatureScales\TemperatureScale;
use DateTimeImmutable;
use App\Services\WeatherPredictions\ForecastProviders\DataTransferObjects\Prediction;
use App\Services\WeatherPredictions\ForecastProviders\DataTransferObjects\HourPrediction;

class JSON extends ForecastProvider
{
    public function getForecast(
        DateTimeImmutable $forecastDate,
        TemperatureScale $temperatureScale,
        TemperatureConverter $temperatureConverter,
    ): Prediction
    {
        $jsonWeatherData = file_get_contents(public_path('ForecastProviderData/temps.json'));
        $weatherData = json_decode($jsonWeatherData, true);

        $date = $weatherData['predictions']['date'];

        $hourPredictions = [];
        foreach ($weatherData['predictions']['prediction'] as $prediction) {
            $time = $this->createDateTimeImmutable(
                $date,
                $prediction['time']
            );

            $convertedTemperature = $temperatureConverter->convert(
                temperature: (float) $prediction['value'],
                from: $temperatureConverter->getScaleByName($weatherData['predictions']['-scale']),
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
