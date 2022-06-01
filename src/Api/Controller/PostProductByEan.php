<?php

namespace App\Api\Controller;

use App\Entity\Product;
use App\Service\PostProductByEanService;

class PostProductByEan
{
    public static $operationName = 'post_product_by_ean';

    public function __construct(
        private PostProductByEanService $postProductByEanService
    )
    {
    }

    public function __invoke(Product $data): Product
    {
        $this->postProductByEanService->validate($data);
        return $this->postProductByEanService->find($data->getEan());
    }
}