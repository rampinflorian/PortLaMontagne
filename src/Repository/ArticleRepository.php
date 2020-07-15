<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @param string $order
     * @return Article[] Returns an array of Article objects
     */
    public function findAllByOrder(string $order)
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.createdAt', $order)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return int|mixed|string
     */
    public function findByActivatedAlert()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.alert IS NOT NULL')
            ->andWhere('a.isPublished = :value')
            ->setParameter('value', true)
            ->getQuery()
            ->getResult();
    }

    public function FindLastActiveWithMaxResult(int $maxResult)
    {
        return $this->createQueryBuilder('a')
            ->where('a.isPublished = :value')
            ->setParameter('value', true)
            ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults($maxResult)
            ->getQuery()
            ->getResult();
    }

    public function FindAllActive()
    {
        return $this->createQueryBuilder('a')
            ->where('a.isPublished = :value')
            ->setParameter('value', true)
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
