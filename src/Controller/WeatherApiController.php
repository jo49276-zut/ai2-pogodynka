<?php

namespace App\Controller;

use App\Service\WeatherUtil;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;

#[Route('/api/v1/weather', name: 'app_weather_api')]
class WeatherApiController extends AbstractController {
    private WeatherUtil $weatherUtil;

    public function __construct(WeatherUtil $weatherUtil) {
        $this->weatherUtil = $weatherUtil;
    }

    #[Route('/', name: 'weather_index', methods: ['GET'])]
    public function index(
        #[MapQueryParameter('country')] string $country,
        #[MapQueryParameter('city')] string $city,
        #[MapQueryParameter('format')] string $format = 'json',
        #[MapQueryParameter('twig')] bool $twig = false
    ): Response {
        try {
            $weatherData = $this->weatherUtil->getWeatherForCountryAndCity($country, $city);
            $weatherDataMeasurements = array_map(function ($data) {
                return [
                    'date' => $data->getDate()->format('Y-m-d'),
                    'celsius' => $data->getCelsius(),
                    'fahrenheit' => $data->getFahrenheit(),
                ];
            }, $weatherData);

            if ($twig) {
                $template = strtolower($format) === 'csv' ? 'weather_api/index.csv.twig' : 'weather_api/index.json.twig';
                return $this->render($template, [
                    'city' => $city,
                    'country' => $country,
                    'measurements' => $weatherDataMeasurements,
                ]);
            }

            if (strtolower($format) === 'csv') {
                $csvData = array_map(function ($data) use ($country, $city) {
                    return sprintf("%s,%s,%s,%s,%s",
                        $city, $country, $data->getDate()->format('Y-m-d'),
                        $data->getCelsius(), $data->getFahrenheit());
                }, $weatherData);

                array_unshift($csvData, 'city,country,date,celsius,fahrenheit');
                $csvString = implode("\n", $csvData);

                $response = new Response($csvString);
                $response->headers->set('Content-Type', 'text/plain');
                return $response;
            }

            return $this->json([
                'country' => $country,
                'city' => $city,
                'measurements' => $weatherDataMeasurements,
            ]);

        } catch (Exception $e) {
            return $this->json([
                'error' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
    }
}