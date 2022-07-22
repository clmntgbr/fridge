<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Item;
use App\Entity\User;
use App\Entity\UserGasStation;
use App\Repository\UserGasStationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Security\Core\Security;

class PostItemsCollectionDataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(
        private Security                 $security,
        private EntityManagerInterface   $em
    )
    {
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Item;
    }

    /**
     * @param Item $data
     */
    public function persist($data, array $context = []): Item
    {
        /** @var User $user */
        $user = $this->security->getUser();

        if (null === $user) {
            throw new Exception('Missing user.');
        }

        if (false === $user->getFridges()->contains($data->getFridge())) {
            throw new Exception('You can\'t access this fridge.');
        }

        $this->em->persist($data);
        $this->em->flush();

        return $data;
    }

    public function remove($data, array $context = [])
    {
        return $data;
    }
}