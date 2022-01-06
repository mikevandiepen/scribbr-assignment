<?php

declare(strict_types=1);

namespace App\Services\WeatherPredictions\ForecastProviders;

use App\Services\WeatherPredictions\TemperatureConverter;
use App\Services\WeatherPredictions\TemperatureScales\Celcius;
use App\Services\WeatherPredictions\TemperatureScales\TemperatureScale;
use DateTimeImmutable;
use Exception;
use App\Services\WeatherPredictions\ForecastProviders\DataTransferObjects\Prediction;
use App\Services\WeatherPredictions\ForecastProviders\DataTransferObjects\HourPrediction;
use SimpleXMLElement;

class XML extends ForecastProvider
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
        $xmlWeatherData = simplexml_load_file(
            public_path('ForecastProviderData/temps.xml')
        );

        if ($xmlWeatherData === false) {
            throw new Exception('Failed to retrieve XML forecast information.');
        }

        $json = json_encode($xmlWeatherData);
        $weatherData = json_decode($json,true);

        $date = (string) $weatherData['date'];
        $hourPredictions = [];
        foreach ($weatherData['prediction'] as $prediction) {
            $time = $this->createDateTimeImmutable(
                $date,
                $prediction['time']
            );

            $convertedTemperature = $temperatureConverter->convert(
                temperature: (float) $prediction['value'],
                from: $temperatureConverter->getScaleByName($weatherData['@attributes']['scale']),
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
