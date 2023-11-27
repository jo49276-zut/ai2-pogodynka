<?php

namespace App\Controller;

use App\Repository\CityRepository;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    private WeatherUtil $weatherUtil;

    public function __construct(WeatherUtil $weatherUtil) {
        $this->weatherUtil = $weatherUtil;
    }

    #[Route('/weather/{cityName}', name: 'app_weather')]
    public function city(string $cityName, CityRepository $cityRepo): Response {
        $city = $cityRepo->findOneBy(['name' => $cityName]);

        if (!$city) {
            throw $this->createNotFoundException('City not found');
        }

        $weatherData = [];

        try {
            $weatherData = $this->weatherUtil->getWeatherForCity($city);
        } catch (\Exception $e) {
            $this->addFlash('error', $e->getMessage());
        }

        return $this->render('weather/city.html.twig', [
            'city' => $city,
            'weather_data' => $weatherData,
        ]);
    }
}