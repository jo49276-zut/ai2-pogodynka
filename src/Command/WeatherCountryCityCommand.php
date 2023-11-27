<?php

namespace App\Command;

use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:country-city',
    description: 'Displays weather information for a given country code and city name.',
)]
class WeatherCountryCityCommand extends Command {
    private WeatherUtil $weatherUtil;

    public function __construct(WeatherUtil $weatherUtil) {
        parent::__construct();
        $this->weatherUtil = $weatherUtil;
    }

    protected function configure(): void {
        $this
            ->addArgument('countryCode', InputArgument::REQUIRED, 'Kod kraju')
            ->addArgument('cityName', InputArgument::REQUIRED, 'Nazwa miasta');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $io = new SymfonyStyle($input, $output);
        $countryCode = $input->getArgument('countryCode');
        $cityName = $input->getArgument('cityName');

        try {
            $weatherData = $this->weatherUtil->getWeatherForCountryAndCity($countryCode, $cityName);
            if (empty($weatherData)) {
                $io->warning('Brak danych pogodowych dla: ' . $cityName);
                return Command::SUCCESS;
            }

            $io->title('Pogoda dla miasta ' . $cityName);
            foreach ($weatherData as $data) {
                $io->writeln(sprintf("%s: %s°C",
                    $data->getDate()->format('Y-m-d'),
                    $data->getCelsius()
                ));
            }
        } catch (\Exception $e) {
            $io->error('Błąd: ' . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}