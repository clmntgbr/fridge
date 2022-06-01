<?php

namespace App\Service;

class OpenFoodFactApiService
{
    public function find(string $productEan): ?array
    {
        $url = 'https://fr.openfoodfacts.org/api/v0/produit/' . $productEan . '.json';

        $response = file_get_contents($url);
        $response = json_decode($response, true);

        if (isset($response['status_verbose']) && $response['status_verbose'] === 'product not found') {
            throw new \Exception('Product not found');
        }

        return $response;
    }
}