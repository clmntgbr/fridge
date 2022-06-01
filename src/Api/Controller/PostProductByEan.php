<?php

namespace App\Api\Controller;

use App\Entity\Product;
use App\Service\PostProductByEanService;
use Symfony\Component\HttpFoundation\Request;

class PostProductByEan
{
    public static $operationName = 'post_product_by_ean';

    public function __construct(
        private PostProductByEanService $postProductByEanService
    )
    {
    }

    public function __invoke(Request $request): Product
    {
        return $this->postProductByEanService
            ->hydrate($request)
            ->validate()
            ->find()
        ;
    }
}