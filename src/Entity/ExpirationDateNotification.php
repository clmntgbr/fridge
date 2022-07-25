<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ExpirationDateNotificationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpirationDateNotificationRepository::class)]
#[ApiResource]
class ExpirationDateNotification
{

    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: Types::INTEGER)]
    private ?int $id;

    #[ORM\Column(type: Types::INTEGER)]
    private string $daysBefore;

    #[ORM\ManyToOne(targetEntity: User::class, fetch: 'EXTRA_LAZY', inversedBy: 'expirationDateNotifications')]
    private ?User $user;

    public function __construct()
    {
        $this->daysBefore = 5;
    }

    public function __toString(): string
    {
        return sprintf('%s days before', $this->daysBefore);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDaysBefore(): ?int
    {
        return $this->daysBefore;
    }

    public function setDaysBefore(int $daysBefore): self
    {
        $this->daysBefore = $daysBefore;

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
}
