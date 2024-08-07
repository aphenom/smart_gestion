<?php

namespace App\Repository;

use App\Entity\CreditArticle;
use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CreditArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method CreditArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method CreditArticle[]    findAll()
 * @method CreditArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreditArticleRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, CreditArticle::class);
    }

    // /**
    //  * @return CreditArticle[] Returns an array of CreditArticle objects
    //  */
    /*
      public function findByExampleField($value)
      {
      return $this->createQueryBuilder('c')
      ->andWhere('c.exampleField = :val')
      ->setParameter('val', $value)
      ->orderBy('c.id', 'ASC')
      ->setMaxResults(10)
      ->getQuery()
      ->getResult()
      ;
      }
     */

    /*
      public function findOneBySomeField($value): ?CreditArticle
      {
      return $this->createQueryBuilder('c')
      ->andWhere('c.exampleField = :val')
      ->setParameter('val', $value)
      ->getQuery()
      ->getOneOrNullResult()
      ;
      }
     */
    public function quantite(?Article $article): ?int {
        $queryBuilder = $this->createQueryBuilder('c')
                ->select('SUM(c.quantite)') // récupération des alias obligatoire pour que la jointure soit effective
                ->leftJoin('c.article', 'a');

        if ($article) {
            $queryBuilder->andWhere('c.article = :article')
                    ->setParameter('article', $article);
        }
        
        $query = $queryBuilder->getQuery();

        return $query->getSingleScalarResult();
    }

}
