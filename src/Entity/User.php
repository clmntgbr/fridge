<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class), UniqueEntity('email', 'username')]
#[ApiResource(
    collectionOperations: ['get'],
    itemOperations: ['get']
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableEntity;

    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: Types::INTEGER)]
    private ?int $id;

    #[ORM\Column(type: Types::STRING, length: 200, unique: true)]
    private string $email;

    #[ORM\Column(type: Types::STRING, length: 200)]
    private string $username;

    #[ORM\Column(type: Types::JSON)]
    private array $roles = [];

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $password;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $isEnable;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Fridge::class, cascade: ['persist'])]
    private Collection $fridges;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ExpirationDateNotification::class, cascade: ['persist']), ORM\OrderBy(['daysBefore' => 'ASC'])]
    private Collection $expirationDateNotifications;

    private ?string $plainPassword = null;

    public function __construct()
    {
        $this->id = rand();
        $this->isEnable = false;
        $this->fridges = new ArrayCollection();
        $this->expirationDateNotifications = new ArrayCollection();
    }

    public function __toString(): string
    {
        return sprintf('%s - %s', $this->id, $this->email);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return array<mixed>
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array<mixed> $roles
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string|null $plainPassword
     * @return User
     */
    public function setPlainPassword(?string $plainPassword): User
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        $this->username = $email;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getIsEnable(): bool
    {
        return $this->isEnable;
    }

    public function setIsEnable(bool $isEnable): self
    {
        $this->isEnable = $isEnable;

        return $this;
    }

    public function isIsEnable(): ?bool
    {
        return $this->isEnable;
    }

    /**
     * @return Collection<int, Fridge>
     */
    public function getFridges(): Collection
    {
        return $this->fridges;
    }

    public function addFridge(Fridge $fridge): self
    {
        if (!$this->fridges->contains($fridge)) {
            $this->fridges[] = $fridge;
            $fridge->setUser($this);
        }

        return $this;
    }

    public function removeFridge(Fridge $fridge): self
    {
        if ($this->fridges->removeElement($fridge)) {
            // set the owning side to null (unless already changed)
            if ($fridge->getUser() === $this) {
                $fridge->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ExpirationDateNotification>
     */
    public function getExpirationDateNotifications(): Collection
    {
        return $this->expirationDateNotifications;
    }

    public function addExpirationDateNotification(ExpirationDateNotification $expirationDateNotification): self
    {
        if (!$this->expirationDateNotifications->contains($expirationDateNotification)) {
            $this->expirationDateNotifications[] = $expirationDateNotification;
            $expirationDateNotification->setUser($this);
        }

        return $this;
    }

    public function removeExpirationDateNotification(ExpirationDateNotification $expirationDateNotification): self
    {
        if ($this->expirationDateNotifications->removeElement($expirationDateNotification)) {
            // set the owning side to null (unless already changed)
            if ($expirationDateNotification->getUser() === $this) {
                $expirationDateNotification->setUser(null);
            }
        }

        return $this;
    }
}