<?php

namespace App\Repository;

use App\Entity\Amenagement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Amenagement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Amenagement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Amenagement[]    findAll()
 * @method Amenagement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AmenagementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Amenagement::class);
    }

    // /**
    //  * @return Amenagement[] Returns an array of Amenagement objects
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
    public function findOneBySomeField($value): ?Amenagement
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
