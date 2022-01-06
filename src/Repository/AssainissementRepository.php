<?php

namespace App\Repository;

use App\Entity\Assainissement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Assainissement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Assainissement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Assainissement[]    findAll()
 * @method Assainissement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssainissementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Assainissement::class);
    }

    // /**
    //  * @return Assainissement[] Returns an array of Assainissement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Assainissement
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByCategory($cat)
    {
        return $this->createQueryBuilder('fbc') // 'fls' est un alias
            ->andWhere('fbc.category = :val')
            ->setParameter('val', $cat)
            ->orderBy('fbc.category', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }
}
