<?php

namespace App\Command;

use App\Repository\CityRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:city',
    description: 'Displays weather information for a given city.',
)]
class WeatherCityCommand extends Command
{
    private WeatherUtil $weatherUtil;
    private CityRepository $cityRepository;

    public function __construct(WeatherUtil $weatherUtil, CityRepository $cityRepository) {
        parent::__construct();
        $this->weatherUtil = $weatherUtil;
        $this->cityRepository = $cityRepository;
    }

    protected function configure(): void {
        $this
            ->addArgument('id', InputArgument::REQUIRED, 'The ID of the city');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $io = new SymfonyStyle($input, $output);
        $cityId = $input->getArgument('id');
        $city = $this->cityRepository->find($cityId);

        if (!$city) {
            $io->error('City not found');
            return Command::FAILURE;
        }

        $weatherData = $this->weatherUtil->getWeatherForCity($city);
        $io->writeln(sprintf('Location: %s', $city->getName()));
        foreach ($weatherData as $measurement) {
            $io->writeln(sprintf("\t%s: %s°C",
                $measurement->getDate()->format('Y-m-d'),
                $measurement->getCelsius()
            ));
        }

        return Command::SUCCESS;
    }
}