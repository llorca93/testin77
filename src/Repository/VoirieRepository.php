<?php

namespace App\Repository;

use App\Entity\Voirie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Voirie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Voirie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Voirie[]    findAll()
 * @method Voirie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoirieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Voirie::class);
    }

    // /**
    //  * @return Voirie[] Returns an array of Voirie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Voirie
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
