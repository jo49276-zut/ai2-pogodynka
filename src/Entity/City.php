<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CityRepository::class)]
class City
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(type: "decimal", precision: 10, scale: 6)]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'float')]
    private ?float $latitude = null;

    #[ORM\Column(type: "decimal", precision: 10, scale: 6)]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'float')]
    private ?float $longitude = null;

    #[ORM\Column(type: "string", length: 2)]
    private ?string $countryCode = null;

    #[ORM\OneToMany(mappedBy: 'city', targetEntity: WeatherData::class)]
    private Collection $weatherData;

    public function __construct()
    {
        $this->weatherData = new ArrayCollection();
    }

    public function getCountryCode(): ?string {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): self {
        $this->countryCode = $countryCode;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return Collection<int, WeatherData>
     */
    public function getWeatherData(): Collection
    {
        return $this->weatherData;
    }

    public function addWeatherData(WeatherData $weatherData): static
    {
        if (!$this->weatherData->contains($weatherData)) {
            $this->weatherData->add($weatherData);
            $weatherData->setCity($this);
        }

        return $this;
    }

    public function removeWeatherData(WeatherData $weatherData): static
    {
        if ($this->weatherData->removeElement($weatherData)) {
            // set the owning side to null (unless already changed)
            if ($weatherData->getCity() === $this) {
                $weatherData->setCity(null);
            }
        }

        return $this;
    }
}
