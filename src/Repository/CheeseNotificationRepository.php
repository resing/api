<?php

namespace App\Repository;

use App\Entity\CheeseNotification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CheeseNotification|null find($id, $lockMode = null, $lockVersion = null)
 * @method CheeseNotification|null findOneBy(array $criteria, array $orderBy = null)
 * @method CheeseNotification[]    findAll()
 * @method CheeseNotification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CheeseNotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CheeseNotification::class);
    }

    // /**
    //  * @return CheeseNotification[] Returns an array of CheeseNotification objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CheeseNotification
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
