<?php

namespace App\Repository;

use App\Entity\ExpirationDateNotification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExpirationDateNotification>
 *
 * @method ExpirationDateNotification|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExpirationDateNotification|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExpirationDateNotification[]    findAll()
 * @method ExpirationDateNotification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpirationDateNotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExpirationDateNotification::class);
    }

    public function add(ExpirationDateNotification $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ExpirationDateNotification $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ExpirationDateNotification[] Returns an array of ExpirationDateNotification objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ExpirationDateNotification
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
