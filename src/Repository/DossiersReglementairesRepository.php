<?php

namespace App\Repository;

use App\Entity\DossiersReglementaires;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DossiersReglementaires|null find($id, $lockMode = null, $lockVersion = null)
 * @method DossiersReglementaires|null findOneBy(array $criteria, array $orderBy = null)
 * @method DossiersReglementaires[]    findAll()
 * @method DossiersReglementaires[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DossiersReglementairesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DossiersReglementaires::class);
    }

    // /**
    //  * @return DossiersReglementaires[] Returns an array of DossiersReglementaires objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DossiersReglementaires
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
