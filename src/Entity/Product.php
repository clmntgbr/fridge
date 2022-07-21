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
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(
    collectionOperations: [
        'post_product_by_ean' => [
            'method' => 'POST',
            'path' => '/products/ean',
            'controller' => PostProductByEan::class,
            'pagination_enabled' => false,
            'deserialize' => false,
            'denormalization_context' => ['groups' => 'product.post'],
        ]
    ],
    itemOperations: ['get'],
    normalizationContext: ['groups' => ['product.read']]
)]
#[Vich\Uploadable]
class Product
{
    use TimestampableEntity;

    #[Groups(['product.post'])]
    private ?UploadedFile $file;

    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: Types::INTEGER), Groups(['product.read'])]
    private ?int $id;

    #[ORM\Column(type: Types::STRING, unique: true), Groups(['product.post', 'product.read']), ApiProperty(identifier: true)]
    private string $ean;

    #[ORM\Column(type: Types::STRING), Groups(['product.read'])]
    private string $name;

    #[ORM\Column(type: Types::STRING), Groups(['product.read'])]
    private string $brand;

    #[ORM\Column(type: Types::ARRAY)]
    private array $data = [];

    #[Vich\UploadableField(mapping: 'product_image', fileNameProperty:'image.name', size:'image.size', mimeType:'image.mimeType', originalName:'image.originalName', dimensions:'image.dimensions')]
    private ?File $imageFile = null;

    #[ORM\Embedded(class:'Vich\UploaderBundle\Entity\File')]
    private EmbeddedFile $image;

    #[Vich\UploadableField(mapping: 'product_image', fileNameProperty:'imageIngredients.name', size:'imageIngredients.size', mimeType:'imageIngredients.mimeType', originalName:'imageIngredients.originalName', dimensions:'imageIngredients.dimensions')]
    private ?File $imageIngredientsFile = null;

    #[ORM\Embedded(class:'Vich\UploaderBundle\Entity\File')]
    private EmbeddedFile $imageIngredients;

    #[Vich\UploadableField(mapping: 'product_image', fileNameProperty:'imageNutrition.name', size:'imageNutrition.size', mimeType:'imageNutrition.mimeType', originalName:'imageNutrition.originalName', dimensions:'imageNutrition.dimensions')]
    private ?File $imageNutritionFile = null;

    #[ORM\Embedded(class:'Vich\UploaderBundle\Entity\File')]
    private EmbeddedFile $imageNutrition;

    #[ORM\ManyToOne(targetEntity: ProductStatus::class, cascade: ['persist']), ORM\JoinColumn(nullable: true), Groups(['product.read'])]
    private ProductStatus $productStatus;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductStatusHistory::class, cascade: ['remove']), Groups(['product.read'])]
    private Collection $productStatusHistories;

    public function __construct()
    {
        $this->productStatusHistories = new ArrayCollection();
        $this->image = new \Vich\UploaderBundle\Entity\File();
        $this->imageIngredients = new \Vich\UploaderBundle\Entity\File();
        $this->imageNutrition = new \Vich\UploaderBundle\Entity\File();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    #[Groups(['product.read'])]
    public function getImageName()
    {
        return $this->image->getName();
    }

    #[Groups(['product.read'])]
    public function getImageIngredientsName()
    {
        return $this->imageIngredients->getName();
    }

    #[Groups(['product.read'])]
    public function getImageNutritionName()
    {
        return $this->imageNutrition->getName();
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

    /**
     * @return array<mixed>
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array<mixed> $element
     */
    public function setData(array $element): self
    {
        $this->data = $element;

        return $this;
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

    /**
     * @return UploadedFile|null
     */
    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    /**
     * @param UploadedFile|null $file
     */
    public function setFile(?UploadedFile $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function setImageFile(?File $imageFile = null)
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImage(EmbeddedFile $image): void
    {
        $this->image = $image;
    }

    public function getImage(): ?EmbeddedFile
    {
        return $this->image;
    }

    public function setImageIngredientsFile(?File $imageFile = null)
    {
        $this->imageIngredientsFile = $imageFile;

        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageIngredientsFile(): ?File
    {
        return $this->imageIngredientsFile;
    }

    public function setImageIngredients(EmbeddedFile $image): void
    {
        $this->imageIngredients = $image;
    }

    public function getImageIngredients(): ?EmbeddedFile
    {
        return $this->imageIngredients;
    }

    public function setImageNutritionFile(?File $imageFile = null)
    {
        $this->imageNutritionFile = $imageFile;

        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageNutritionFile(): ?File
    {
        return $this->imageNutritionFile;
    }

    public function setImageNutrition(EmbeddedFile $image): void
    {
        $this->imageNutrition = $image;
    }

    public function getImageNutrition(): ?EmbeddedFile
    {
        return $this->imageNutrition;
    }
}
