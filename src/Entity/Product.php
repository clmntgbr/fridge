<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Api\Controller\PostProductByEan;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(
    collectionOperations: [
        'post_product_by_ean' => [
            'method' => 'POST',
            'path' => '/products/ean',
            'controller' => PostProductByEan::class,
            'pagination_enabled' => false,
            'denormalization_context' => ['groups' => 'product.post'],
        ]
    ],
    itemOperations: ['get'],
    normalizationContext: ['groups' => ['product.read']]
)]
class Product
{
    use TimestampableEntity;

    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: Types::INTEGER)]
    private ?int $id;

    #[ORM\Column(type: Types::STRING, unique: true), Groups(['product.post', 'product.read']), ApiProperty(identifier: true)]
    private string $ean;

    #[ORM\Column(type: Types::STRING), Groups(['product.read'])]
    private string $name;

    #[ORM\Column(type: Types::STRING), Groups(['product.read'])]
    private string $brand;

    #[ORM\Column(type: Types::STRING), Groups(['product.read'])]
    private string $imageUrl;

    #[ORM\Column(type: Types::STRING), Groups(['product.read'])]
    private string $imageIngredientsUrl;

    #[ORM\Column(type: Types::STRING), Groups(['product.read'])]
    private string $imageNutritionUrl;

    #[ORM\ManyToOne(targetEntity: ProductStatus::class, cascade: ['persist']), ORM\JoinColumn(nullable: true), Groups(['product.read'])]
    private ProductStatus $productStatus;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductStatusHistory::class), Groups(['product.read'])]
    private Collection $productStatusHistories;

    public function __construct()
    {
        $this->productStatusHistories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEan(): ?string
    {
        return $this->ean;
    }

    public function setEan(string $ean): self
    {
        $this->ean = $ean;

        return $this;
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

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getImageIngredientsUrl(): ?string
    {
        return $this->imageIngredientsUrl;
    }

    public function setImageIngredientsUrl(string $imageIngredientsUrl): self
    {
        $this->imageIngredientsUrl = $imageIngredientsUrl;

        return $this;
    }

    public function getImageNutritionUrl(): ?string
    {
        return $this->imageNutritionUrl;
    }

    public function setImageNutritionUrl(string $imageNutritionUrl): self
    {
        $this->imageNutritionUrl = $imageNutritionUrl;

        return $this;
    }

    public function getProductStatus(): ?ProductStatus
    {
        return $this->productStatus;
    }

    public function setProductStatus(?ProductStatus $productStatus): self
    {
        $this->productStatus = $productStatus;

        return $this;
    }

    /**
     * @return Collection<int, ProductStatusHistory>
     */
    public function getProductStatusHistories(): Collection
    {
        return $this->productStatusHistories;
    }

    public function addProductStatusHistory(ProductStatusHistory $productStatusHistory): self
    {
        if (!$this->productStatusHistories->contains($productStatusHistory)) {
            $this->productStatusHistories[] = $productStatusHistory;
            $productStatusHistory->setProduct($this);
        }

        return $this;
    }

    public function removeProductStatusHistory(ProductStatusHistory $productStatusHistory): self
    {
        if ($this->productStatusHistories->removeElement($productStatusHistory)) {
            // set the owning side to null (unless already changed)
            if ($productStatusHistory->getProduct() === $this) {
                $productStatusHistory->setProduct(null);
            }
        }

        return $this;
    }
}
