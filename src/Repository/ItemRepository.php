<?php

namespace App\Repository;

use App\Entity\ConsumptionDateNotification;
use App\Entity\Fridge;
use App\Entity\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Item>
 *
 * @method Item|null find($id, $lockMode = null, $lockVersion = null)
 * @method Item|null findOneBy(array $criteria, array $orderBy = null)
 * @method Item[]    findAll()
 * @method Item[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }

    public function add(Item $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Item $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findItemsByDaysBefore(ConsumptionDateNotification $consumptionDateNotification, Fridge $fridge): array
    {
        $date = (new \DateTime(sprintf('+ %s days', $consumptionDateNotification->getDaysBefore())))->format('Y-m-d');

        return $this->createQueryBuilder('c')
            ->andWhere('c.consumptionDate = :val')
            ->andWhere('c.fridge = :fridge')
            ->setParameters([
                'fridge' => $fridge,
                'val' => $date,
            ])
            ->getQuery()
            ->getResult()
            ;
    }
}
