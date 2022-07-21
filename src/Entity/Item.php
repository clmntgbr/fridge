<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ItemRepository;
use App\Service\Uuid;
use App\Validator\Constraints\IsUserFridge;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
#[ApiResource(
    collectionOperations: [
        'post' => ['denormalization_context' => ['groups' => 'item.post']],
        'get'
    ],
    itemOperations: ['get'],
    normalizationContext: ['groups' => ['item.read']]
)]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'NONE'), ORM\Column(type: Types::STRING), Groups(['item.read'])]
    private string $id;

    #[ORM\ManyToOne(targetEntity: Fridge::class, fetch: 'EXTRA_LAZY', inversedBy: 'items'), Groups(['item.read', 'item.post']), NotBlank, NotNull, IsUserFridge]
    private Fridge $fridge;

    #[ORM\ManyToOne(targetEntity: Product::class, fetch: 'EAGER'), Groups(['item.read', 'item.post']), NotBlank, NotNull]
    private Product $product;

    #[ORM\OneToOne(mappedBy: 'item', targetEntity: ConsumptionDate::class, cascade: ['remove'], fetch: 'EXTRA_LAZY'), Groups(['item.read'])]
    private ConsumptionDate $consumptionDate;

    public function __construct()
    {
        $this->id = Uuid::v4();
    }

    public function __toString(): string
    {
        return sprintf('%s - %s - %s', $this->product->getEan(), $this->product->getName(), $this->consumptionDate->getDate()->format('d/m/Y'));
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getFridge(): ?Fridge
    {
        return $this->fridge;
    }

    public function setFridge(?Fridge $fridge): self
    {
        $this->fridge = $fridge;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getConsumptionDate(): ?ConsumptionDate
    {
        return $this->consumptionDate;
    }

    public function setConsumptionDate(?ConsumptionDate $ConsumptionDate): self
    {
        $this->consumptionDate = $ConsumptionDate;

        return $this;
    }
}
