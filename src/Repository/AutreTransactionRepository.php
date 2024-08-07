<?php

namespace App\Repository;

use App\Entity\AutreTransaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AutreTransaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method AutreTransaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method AutreTransaction[]    findAll()
 * @method AutreTransaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AutreTransactionRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, AutreTransaction::class);
    }

    // /**
    //  * @return AutreTransaction[] Returns an array of AutreTransaction objects
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
      public function findOneBySomeField($value): ?AutreTransaction
      {
      return $this->createQueryBuilder('a')
      ->andWhere('a.exampleField = :val')
      ->setParameter('val', $value)
      ->getQuery()
      ->getOneOrNullResult()
      ;
      }
     */

    public function montantEntrees(): ?int {
        return $this->createQueryBuilder('a')
                        ->select('SUM(a.montant)')
                        ->andWhere('a.type_transaction = :type_transaction')
                        ->andWhere('a.etat_val = :etat_val')
                        ->andWhere('a.etat_del = :etat_del')
                        ->setParameter('type_transaction', 'entree')
                        ->setParameter('etat_val', true)
                        ->setParameter('etat_del', false)
                        ->getQuery()
                        ->getSingleScalarResult()
        ;
    }
    
        public function montantSorties(): ?int {
        return $this->createQueryBuilder('a')
                        ->select('SUM(a.montant)')
                        ->andWhere('a.type_transaction = :type_transaction')
                        ->andWhere('a.etat_val = :etat_val')
                        ->andWhere('a.etat_del = :etat_del')
                        ->setParameter('type_transaction', 'sortie')
                        ->setParameter('etat_val', true)
                        ->setParameter('etat_del', false)
                        ->getQuery()
                        ->getSingleScalarResult()
        ;
    }

}
