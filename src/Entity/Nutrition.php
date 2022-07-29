<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\NutritionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: NutritionRepository::class)]
#[ApiResource(
    itemOperations: ['get'],
)]
class Nutrition
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: Types::INTEGER)]
    private ?int $id;

    #[ORM\Column(type: Types::STRING, nullable: true), Groups(['product.read'])]
    private ?string $categories;

    #[ORM\Column(type: Types::STRING, nullable: true), Groups(['product.read'])]
    private ?string $country;

    #[ORM\Column(type: Types::STRING, nullable: true), Groups(['product.read'])]
    private ?string $ecoscoreGrade;

    #[ORM\Column(type: Types::STRING, nullable: true), Groups(['product.read'])]
    private ?string $ecoscoreScore;

    #[ORM\Column(type: Types::STRING, nullable: true), Groups(['product.read'])]
    private ?string $ingredientsText;

    #[ORM\Column(type: Types::STRING, nullable: true), Groups(['product.read'])]
    private ?string $nutriscoreGrade;

    #[ORM\Column(type: Types::STRING, nullable: true), Groups(['product.read'])]
    private ?string $nutriscoreScore;

    #[ORM\Column(type: Types::STRING, nullable: true), Groups(['product.read'])]
    private ?string $quantity;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getCategories(): ?string
    {
        return $this->categories;
    }

    public function setCategories(?string $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getEcoscoreGrade(): ?string
    {
        return $this->ecoscoreGrade;
    }

    public function setEcoscoreGrade(?string $ecoscoreGrade): self
    {
        $this->ecoscoreGrade = $ecoscoreGrade;

        return $this;
    }

    public function getEcoscoreScore(): ?string
    {
        return $this->ecoscoreScore;
    }

    public function setEcoscoreScore(?string $ecoscoreScore): self
    {
        $this->ecoscoreScore = $ecoscoreScore;

        return $this;
    }

    public function getIngredientsText(): ?string
    {
        return $this->ingredientsText;
    }

    public function setIngredientsText(?string $ingredientsText): self
    {
        $this->ingredientsText = $ingredientsText;

        return $this;
    }

    public function getNutriscoreGrade(): ?string
    {
        return $this->nutriscoreGrade;
    }

    public function setNutriscoreGrade(?string $nutriscoreGrade): self
    {
        $this->nutriscoreGrade = $nutriscoreGrade;

        return $this;
    }

    public function getNutriscoreScore(): ?string
    {
        return $this->nutriscoreScore;
    }

    public function setNutriscoreScore(?string $nutriscoreScore): self
    {
        $this->nutriscoreScore = $nutriscoreScore;

        return $this;
    }

    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    public function setQuantity(?string $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
