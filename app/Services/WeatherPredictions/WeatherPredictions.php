<?php

declare(strict_types=1);

namespace App\Services\WeatherPredictions;

use App\Services\WeatherPredictions\ForecastProviders\DataTransferObjects\HourPrediction;
use App\Services\WeatherPredictions\ForecastProviders\DataTransferObjects\Prediction;
use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use App\Services\WeatherPredictions\ForecastProviders\CSV;
use App\Services\WeatherPredictions\ForecastProviders\ForecastProvider;
use App\Services\WeatherPredictions\ForecastProviders\JSON;
use App\Services\WeatherPredictions\ForecastProviders\XML;
use App\Services\WeatherPredictions\TemperatureScales\TemperatureScale;

class WeatherPredictions
{
    /**
     * @throws Exception
     */
    public function getWeatherPredictions(
        DateTimeImmutable $forecastDate,
        TemperatureScale $temperatureScale,
        TemperatureConverter $temperatureConverter): Prediction
    {
        if (!$this->forecastIsWithinTenDays($forecastDate)) {
            throw new \Exception('You can only see the forecast for the coming ten days.');
        }

        return $this->getAverageForecastData(
            $forecastDate,
            $temperatureScale,
            $temperatureConverter
        );
    }

    /**
     * @param DateTimeImmutable $forecastDate
     * @return bool
     */
    private function forecastIsWithinTenDays(DateTimeImmutable $forecastDate): bool
    {
        $currentDate = new DateTimeImmutable();

        $daysBetween = $forecastDate->diff($currentDate)->days;

        // The forecast can not be before the current date.
        if (strtotime($forecastDate->format('Y-m-d')) < strtotime($currentDate->format('Y-m-d'))) {
            return false;

        }

        // The difference between the queried date and the current date cannot be greater than 10 days.
        return ($daysBetween !== false && $daysBetween <= 10);
    }

    private function getAverageForecastData(
        DateTimeImmutable $forecastDate,
        TemperatureScale $temperatureScale,
        TemperatureConverter $temperatureConverter
    ): Prediction
    {
        // Ideally this would be configured inside a config file.
        $providers = [
            CSV::class,
            JSON::class,
            XML::class,
        ];

        // Collecting the forecast data into an array.
        $predictionCollection = [];
        foreach ($providers as $provider) {
            /** @var ForecastProvider $forecastProvider */
            $forecastProvider = new $provider();

            $predictionCollection[] = $forecastProvider->getForecast($forecastDate, $temperatureScale, $temperatureConverter);
        }

        // Mapping the provider data to a uniform structure.
        $mappedHourPredictions = [
            // 'ISO8061' => ['temp1', 'temp2', 'temp3']
        ];
        foreach ($predictionCollection as $prediction) {
            foreach ($prediction->getHourPredictions() as $hourPrediction) {
                $mappedHourPredictions[$hourPrediction->getTime()->format(DateTimeInterface::ISO8601)][] = $hourPrediction->getTemperature();
            }
        }

        // Combining the values and calculating an average.
        $hourPredictions = [];
        foreach ($mappedHourPredictions as $hour => $temperatures) {
            $datetimePredictionHour = DateTimeImmutable::createFromFormat(
                DateTimeInterface::ISO8601,
                $hour
            );

            $averageTempInKelvin = array_sum($temperatures) / count($temperatures);

            $hourPredictions[] = new HourPrediction($datetimePredictionHour, (float) $averageTempInKelvin);
        }

        // Parsing through each forecast.
        return new Prediction(
            $forecastDate,
            $hourPredictions
        );
    }
}
