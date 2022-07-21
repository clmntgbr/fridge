<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FridgeRepository;
use App\Service\Uuid;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: FridgeRepository::class)]
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: ['get', 'delete'],
    denormalizationContext: ['groups' => ['fridge.post']],
    normalizationContext: ['groups' => ['fridge.read']]
)]
class Fridge
{
    use TimestampableEntity;

    #[ORM\Id, ORM\GeneratedValue(strategy: 'NONE'), ORM\Column(type: Types::STRING), Groups(['fridge.read'])]
    private ?string $id;

    #[ORM\Column(type: Types::STRING), Groups(['fridge.read'])]
    private string $name;

    #[ORM\ManyToOne(targetEntity: User::class, fetch: 'EXTRA_LAZY', inversedBy: 'fridges'), ORM\JoinTable(name: 'user_id'), Groups(['fridge.read'])]
    private User $user;

    #[ORM\OneToMany(mappedBy: 'fridge', targetEntity: Item::class, cascade: ['remove'])]
    private Collection $items;

    public function __construct()
    {
        $this->id = Uuid::v4();
        $this->name = 'Default';
        $this->items = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->id;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setFridge($this);
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getFridge() === $this) {
                $item->setFridge(null);
            }
        }

        return $this;
    }

    #[SerializedName('items'), Groups(['fridge.read'])]
    public function getItemsCount(): int
    {
        return $this->items->count();
    }
}
