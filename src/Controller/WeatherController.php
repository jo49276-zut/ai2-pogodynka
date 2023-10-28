<?php

namespace App\Controller;

use App\Repository\CityRepository;
use App\Repository\WeatherDataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/{cityName}', name: 'app_weather')]
    public function city(string $cityName, CityRepository $cityRepo, WeatherDataRepository $weatherDataRepo): Response
    {
        $city = $cityRepo->findOneBy(['name' => $cityName]);

        if (!$city) {
            throw $this->createNotFoundException('City not found');
        }

        $weatherData = $weatherDataRepo->findBy(['city' => $city]);

        return $this->render('weather/city.html.twig', [
            'city' => $city,
            'weather_data' => $weatherData,
        ]);
    }
}