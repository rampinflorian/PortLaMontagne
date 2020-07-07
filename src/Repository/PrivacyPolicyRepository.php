<?php

namespace App\Repository;

use App\Entity\PrivacyPolicy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PrivacyPolicy|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrivacyPolicy|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrivacyPolicy[]    findAll()
 * @method PrivacyPolicy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrivacyPolicyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PrivacyPolicy::class);
    }

    // /**
    //  * @return PrivacyPolicy[] Returns an array of PrivacyPolicy objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PrivacyPolicy
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
