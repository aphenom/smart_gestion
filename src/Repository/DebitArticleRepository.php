<?php

namespace App\Repository;

use App\Entity\DebitArticle;
use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DebitArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method DebitArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method DebitArticle[]    findAll()
 * @method DebitArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DebitArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DebitArticle::class);
    }

    // /**
    //  * @return DebitArticle[] Returns an array of DebitArticle objects
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
    public function findOneBySomeField($value): ?DebitArticle
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
        public function quantite(?Article $article): ?int {
        $queryBuilder = $this->createQueryBuilder('d')
                ->select('SUM(d.quantite)') // récupération des alias obligatoire pour que la jointure soit effective
                ->leftJoin('d.article', 'a');

        if ($article) {
            $queryBuilder->andWhere('d.article = :article')
                    ->setParameter('article', $article);
        }
        
        $query = $queryBuilder->getQuery();

        return $query->getSingleScalarResult();
    }

}
