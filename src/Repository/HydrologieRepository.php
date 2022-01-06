<?php

namespace App\Repository;

use App\Entity\Hydrologie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Hydrologie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hydrologie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hydrologie[]    findAll()
 * @method Hydrologie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HydrologieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hydrologie::class);
    }

    // /**
    //  * @return Hydrologie[] Returns an array of Hydrologie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hydrologie
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
