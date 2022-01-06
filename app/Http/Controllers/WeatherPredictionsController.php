<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\WeatherPredictions\ForecastProviders\DataTransferObjects\HourPrediction;
use App\Services\WeatherPredictions\TemperatureConverter;
use App\Services\WeatherPredictions\TemperatureScales\Celcius;
use App\Services\WeatherPredictions\TemperatureScales\Delisle;
use App\Services\WeatherPredictions\TemperatureScales\Fahrenheit;
use App\Services\WeatherPredictions\TemperatureScales\Kelvin;
use App\Services\WeatherPredictions\TemperatureScales\Newton;
use App\Services\WeatherPredictions\TemperatureScales\Rankine;
use App\Services\WeatherPredictions\TemperatureScales\Reaumur;
use App\Services\WeatherPredictions\TemperatureScales\Romer;
use App\Services\WeatherPredictions\WeatherPredictions;
use DateTimeImmutable;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\In;
use Symfony\Component\HttpFoundation\Response;

class WeatherPredictionsController extends Controller
{
    /**
     * @throws Exception
     */
    public function show(
        Request $request,
        WeatherPredictions $weatherPredictions,
        TemperatureConverter $temperatureConverter
    ): JsonResponse
    {
        $request->validate([
            'temperatureScale' => [
                new In([
                    (new Celcius())->__toString(),
                    (new Delisle())->__toString(),
                    (new Fahrenheit())->__toString(),
                    (new Kelvin())->__toString(),
                    (new Newton())->__toString(),
                    (new Rankine())->__toString(),
                    (new Reaumur())->__toString(),
                    (new Romer())->__toString(),
                ])
            ],
            'date' => 'date|date_format:Y-m-d',
        ]);

        $temperatureScale = $temperatureConverter->getScaleByName(
            $request->get('temperatureScale', (new Celcius())->__toString())
        );

        $forecastDate = new DateTimeImmutable($request->get('date'));

        $weatherPredictionData = $weatherPredictions->getWeatherPredictions(
            $forecastDate,
            $temperatureScale,
            $temperatureConverter,
        );

        return new JsonResponse([
            'date' => $weatherPredictionData->getDate()->format('Y-m-d'),
            'temperatureScale' => $temperatureScale->__toString(),
            'predictions' => array_map(function (HourPrediction $hourPrediction) {
                return [
                    'time' => $hourPrediction->getTime()->format('H:i'),
                    'temperature' => $hourPrediction->getTemperature(),
                ];
            }, $weatherPredictionData->getHourPredictions())
        ], Response::HTTP_OK);
    }
}
