<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PostProductByEanService
{
    public function __construct(
        private ValidatorInterface     $validator,
        private ProductRepository      $productRepository,
        private OpenFoodFactApiService $openFoodFactApiService,
        private EntityManagerInterface $em
    )
    {
    }

    public function validate($entity): void
    {
        $errors = $this->validator->validate($entity);

        if (count($errors) > 0) {
            throw new \Exception(sprintf('%s errors : %s', get_class($entity), $errors));
        }
    }

    public function find(string $ean): Product
    {
        $product = $this->productRepository->findOneBy(['ean' => $ean]);

        if (null === $product) {
            $data = $this->openFoodFactApiService->find($ean);
            $product = $this->create($data);
        }

        return $product;
    }

    private function create(array $data): Product
    {
        $product = new Product();
        $product
            ->setEan($data['code'])
            ->setName($data['product']['product_name_fr'] ?? $data['product']['product_name'])
            ->setBrand($data['product']['brands'])
            ->setImageUrl($data['product']['image_url'])
            ->setImageIngredientsUrl($data['product']['image_ingredients_url'])
            ->setImageNutritionUrl($data['product']['image_nutrition_url']);

        $this->em->persist($product);
        $this->em->flush();

        return $product;
    }
}