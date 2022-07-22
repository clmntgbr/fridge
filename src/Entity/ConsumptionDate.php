<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ConsumptionDateRepository;
use App\Validator\Constraints\IsDatePassed;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

#[ORM\Entity(repositoryClass: ConsumptionDateRepository::class)]
#[ApiResource(
    collectionOperations: [
        'post' => ['denormalization_context' => ['groups' => 'consumption_date.post']]
    ],
    itemOperations: ['get']
)]
class ConsumptionDate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: Types::DATE_MUTABLE), Groups(['consumption_date.post']), NotNull, NotBlank, IsDatePassed]
    private \DateTimeInterface $date;

    #[ORM\OneToOne(inversedBy: 'consumptionDate', targetEntity: Item::class, cascade: ['remove'], fetch: 'EXTRA_LAZY'), ORM\JoinColumn(nullable: true), Groups(['item.read', 'consumption_date.post'])]
    private ?Item $item;

    public function __toString(): string
    {
        return $this->date->format('d/m/Y');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;

        return $this;
    }
}
