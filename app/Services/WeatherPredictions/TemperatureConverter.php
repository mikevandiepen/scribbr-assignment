<?php

declare(strict_types=1);

namespace App\Services\WeatherPredictions;

use App\Services\WeatherPredictions\TemperatureScales\Celcius;
use App\Services\WeatherPredictions\TemperatureScales\Delisle;
use App\Services\WeatherPredictions\TemperatureScales\Fahrenheit;
use App\Services\WeatherPredictions\TemperatureScales\Kelvin;
use App\Services\WeatherPredictions\TemperatureScales\Newton;
use App\Services\WeatherPredictions\TemperatureScales\Rankine;
use App\Services\WeatherPredictions\TemperatureScales\Reaumur;
use App\Services\WeatherPredictions\TemperatureScales\Romer;
use App\Services\WeatherPredictions\TemperatureScales\TemperatureScale;

/**
 * To avoid an increasing amount of formula's per temperature-scale we use "kelvin" as our baseline.
 * If we can convert each temperature scale to kelvin we can easily switch between scales.
 */
class TemperatureConverter
{
    public function convert(float $temperature, TemperatureScale $from, TemperatureScale $to): float
    {
        $temperatureInKelvin = $from->convertToKelvin($temperature);

        return $to->convertFromKelvin($temperatureInKelvin);
    }

    public function getScaleByName(string $scaleName): TemperatureScale
    {
        return match(ucfirst($scaleName)) {
            (new Celcius())->__toString() => new Celcius(),
            (new Delisle())->__toString() => new Delisle(),
            (new Fahrenheit())->__toString() => new Fahrenheit(),
            (new Kelvin())->__toString() => new Kelvin(),
            (new Newton())->__toString() => new Newton(),
            (new Rankine())->__toString() => new Rankine(),
            (new Reaumur())->__toString() => new Reaumur(),
            (new Romer())->__toString() => new Romer(),
            default => new Celcius(),
        };
    }
}
