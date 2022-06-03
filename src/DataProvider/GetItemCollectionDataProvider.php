<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Item;
use App\Repository\FridgeRepository;
use App\Repository\ItemRepository;
use Symfony\Component\Security\Core\Security;

class GetItemCollectionDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    public function __construct(
        private Security $security,
        private FridgeRepository $fridgeRepository,
        private ItemRepository $itemRepository
    )
    {
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Item::class === $resourceClass && $operationName === 'get';
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        if (!array_key_exists('filters', $context) || !array_key_exists('fridgeId', $context['filters'])) {
            throw new \Exception('No `fridgeId` in filters');
        }

        $fridge = $this->fridgeRepository->findOneBy(['id' => $context['filters']['fridgeId']]);

        if (!$fridge) {
            throw new \Exception('No fridge found');
        }

        $user = $this->security->getUser();

        if ($fridge->getUser()->getId() !== $user->getId()) {
            throw new \Exception('User not allowed to access this fridge');
        }

        return $this->itemRepository->findBy(['fridge' => $fridge]);
    }
}