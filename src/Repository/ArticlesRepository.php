<?php

namespace App\Repository;

use App\Entity\Articles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Articles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articles[]    findAll()
 * @method Articles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticlesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Articles::class);
    }

    // /**
    //  * @return Articles[] Returns an array of Articles objects
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

    /**
     * Return all articles per page
     * @return void
     */
    public function getPaginatedArticles($page, $limit, $filters = null)
    {
        $query = $this->createQueryBuilder('a')
            ->where('a.active = 1')
            ->andWhere('a.isBest = 0');
            

        // on filtre les données
        if($filters != null){
            $query->andWhere('a.category IN(:cats)')
                ->setParameter(':cats', array_values($filters));
        }


        $query
            ->orderBy('a.createdAt')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit)
        ;
        return $query->getQuery()->getResult();

    }

    /**
     * Returns number of Articles
     * @return void
     */
    public function getTotalArticles($filters = null)
    {
        $query = $this->createQueryBuilder('a')
            ->select('COUNT(a)')
            ->where('a.active = 1')
            ->andWhere('a.isBest = 0');

             // on filtre les données
        if($filters != null){
            $query->andWhere('a.category IN(:cats)')
                ->setParameter(':cats', array_values($filters));
        }
        
        return $query->getQuery()->getSingleScalarResult();
    }

    /*
    public function findOneBySomeField($value): ?Articles
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
