<?php

namespace App\Repository;

use App\Entity\EauPotable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EauPotable|null find($id, $lockMode = null, $lockVersion = null)
 * @method EauPotable|null findOneBy(array $criteria, array $orderBy = null)
 * @method EauPotable[]    findAll()
 * @method EauPotable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EauPotableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EauPotable::class);
    }

    // /**
    //  * @return EauPotable[] Returns an array of EauPotable objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EauPotable
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
