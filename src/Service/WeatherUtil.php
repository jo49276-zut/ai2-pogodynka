<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\City;
use App\Entity\WeatherData;
use App\Repository\CityRepository;
use Exception;

class WeatherUtil {

    private CityRepository $cityRepository;

    public function __construct(CityRepository $cityRepository) {
        $this->cityRepository = $cityRepository;
    }

    /**
     * @return WeatherData[]
     * @throws Exception
     */
    public function getWeatherForCity(City $city): array {
        $weatherData = $city->getWeatherData();
        if ($weatherData->isEmpty()) {
            throw new Exception("Brak danych pogodowych dla miasta: " . $city->getName());
        }
        return $weatherData->toArray();
    }

    /**
     * @return WeatherData[]
     * @throws Exception
     */
    public function getWeatherForCountryAndCity(string $countryCode, string $cityName): array {
        $city = $this->cityRepository->findOneBy([
            'countryCode' => $countryCode,
            'name' => $cityName
        ]);

        if (!$city) {
            throw new Exception("Miasto nie zostało znalezione: " . $cityName . ", kod kraju: " . $countryCode);
        }

        return $this->getWeatherForCity($city);
    }
}