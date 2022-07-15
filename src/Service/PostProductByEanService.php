<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PostProductByEanService
{
    private Product $product;

    public function __construct(
        private ValidatorInterface     $validator,
        private ProductRepository      $productRepository,
        private OpenFoodFactApiService $openFoodFactApiService,
        private EntityManagerInterface $em,
        private GetImage $getImage
    )
    {
    }

    public function hydrate(Request $request): self
    {
        $this->product = new Product();
        $this->product
            ->setFile($request->files->get('file') ?? null)
            ->setEan($request->request->get('ean'))
        ;

        return $this;
    }

    public function validate(): self
    {
        $errors = $this->validator->validate($this->product);

        if (count($errors) > 0) {
            throw new \Exception(sprintf('%s errors : %s', get_class($this->product), $errors));
        }

        return $this;
    }

    public function find(): Product
    {
        $product = $this->productRepository->findOneBy(['ean' => $this->product->getEan()]);

        if (null === $product) {
            $data = $this->openFoodFactApiService->find($this->product->getEan());
            $product = $this->create($data);
        }

        $product->setFile($this->product->getFile());

        return $product;
    }

    private function create(array $data): Product
    {
        $product = new Product();
        $product
            ->setEan($data['code'])
            ->setName($data['product']['product_name_fr'] ?? $data['product']['product_name'])
            ->setBrand($data['product']['brands'])
        ;

        $file = $this->getImage->get($data['product']['image_url'] ?? null);
        if (null !== $file) {
            $product->setImage($file);
        }

        $file = $this->getImage->get($data['product']['image_ingredients_url'] ?? null);
        if (null !== $file) {
            $product->setImageIngredients($file);
        }

        $file = $this->getImage->get($data['product']['image_nutrition_url'] ?? null);
        if (null !== $file) {
            $product->setImageNutrition($file);
        }

        $this->em->persist($product);
        $this->em->flush();

        return $product;
    }
}