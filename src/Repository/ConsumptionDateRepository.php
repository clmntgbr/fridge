<?php

namespace App\Repository;

use App\Entity\ConsumptionDate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConsumptionDate>
 *
 * @method ConsumptionDate|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConsumptionDate|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConsumptionDate[]    findAll()
 * @method ConsumptionDate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsumptionDateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConsumptionDate::class);
    }

    public function add(ConsumptionDate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ConsumptionDate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findConsumptionDateByDaysBefore(int $days): array
    {
        $date = (new \DateTime(sprintf('+ %s days', $days)))->format('Y-m-d');

        return $this->createQueryBuilder('c')
            ->andWhere('c.date = :val')
            ->setParameter('val', $date)
            ->getQuery()
            ->getResult()
        ;
    }
}
