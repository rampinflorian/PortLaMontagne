<?php

namespace App\Repository;

use App\Entity\ClimbingGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClimbingGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClimbingGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClimbingGroup[]    findAll()
 * @method ClimbingGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClimbingGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClimbingGroup::class);
    }

    // /**
    //  * @return ClimbingGroup[] Returns an array of ClimbingGroup objects
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
    public function findOneBySomeField($value): ?ClimbingGroup
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
