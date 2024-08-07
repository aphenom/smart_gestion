<?php

namespace App\Repository;

use App\Entity\CommandeArticle;
use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CommandeArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandeArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandeArticle[]    findAll()
 * @method CommandeArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeArticleRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, CommandeArticle::class);
    }

    // /**
    //  * @return CommandeArticle[] Returns an array of CommandeArticle objects
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
      public function findOneBySomeField($value): ?CommandeArticle
      {
      return $this->createQueryBuilder('c')
      ->andWhere('c.exampleField = :val')
      ->setParameter('val', $value)
      ->getQuery()
      ->getOneOrNullResult()
      ;
      }
     */

    public function enCours(?Article $article): ?int {
        $queryBuilder = $this->createQueryBuilder('ca')
                ->select('SUM(ca.quantite)') // récupération des alias obligatoire pour que la jointure soit effective
                ->leftJoin('ca.article', 'a')
                ->leftJoin('ca.commande', 'c')
                ->andWhere('ca.etat_val = :ca_etat_val')
                ->andWhere('ca.etat_del = :ca_etat_del')
                ->andWhere('c.etat_val = :c_etat_val')
                ->andWhere('c.etat_del = :c_etat_del')
                ->andWhere('c.etat_retour = :c_etat_retour')
                ->andWhere('c.etat_reception = :c_etat_reception')
                ->setParameter('ca_etat_val', true)
                ->setParameter('ca_etat_del', false)
                ->setParameter('c_etat_val', true)
                ->setParameter('c_etat_del', false)
                ->setParameter('c_etat_retour', false)
                ->setParameter('c_etat_reception', false);

        if ($article) {
            $queryBuilder->andWhere('ca.article = :article')
                    ->setParameter('article', $article);
        }

        $query = $queryBuilder->getQuery();

        return $query->getSingleScalarResult();
    }

    public function venteInterne(?Article $article): ?int {
        $queryBuilder = $this->createQueryBuilder('ca')
                ->select('SUM(ca.quantite)') // récupération des alias obligatoire pour que la jointure soit effective
                ->leftJoin('ca.article', 'a')
                ->leftJoin('ca.commande', 'c')
                ->andWhere('ca.etat_val = :ca_etat_val')
                ->andWhere('ca.etat_del = :ca_etat_del')
                ->andWhere('a.etat_proprio = :a_etat_proprio')
                ->andWhere('c.etat_val = :c_etat_val')
                ->andWhere('c.etat_del = :c_etat_del')
                ->andWhere('c.etat_livraison = :c_etat_livraison')
                ->andWhere('c.etat_retour = :c_etat_retour')
                ->andWhere('c.etat_reception = :c_etat_reception')
                ->setParameter('ca_etat_val', true)
                ->setParameter('ca_etat_del', false)
                ->setParameter('a_etat_proprio', true)
                ->setParameter('c_etat_val', true)
                ->setParameter('c_etat_del', false)
                ->setParameter('c_etat_livraison', true)
                ->setParameter('c_etat_retour', false)
                ->setParameter('c_etat_reception', true);

        if ($article) {
            $queryBuilder->andWhere('ca.article = :article')
                    ->setParameter('article', $article);
        }
        $query = $queryBuilder->getQuery();

        return $query->getSingleScalarResult();
    }

    public function venteExterne(): ?int {
        $queryBuilder = $this->createQueryBuilder('ca')
                ->select('SUM(ca.quantite)') // récupération des alias obligatoire pour que la jointure soit effective
                ->leftJoin('ca.article', 'a')
                ->leftJoin('ca.commande', 'c')
                ->andWhere('ca.etat_val = :ca_etat_val')
                ->andWhere('ca.etat_del = :ca_etat_del')
                ->andWhere('a.etat_proprio = :a_etat_proprio')
                ->andWhere('c.etat_val = :c_etat_val')
                ->andWhere('c.etat_del = :c_etat_del')
                ->andWhere('c.etat_livraison = :c_etat_livraison')
                ->andWhere('c.etat_retour = :c_etat_retour')
                ->andWhere('c.etat_reception = :c_etat_reception')
                ->setParameter('ca_etat_val', true)
                ->setParameter('ca_etat_del', false)
                ->setParameter('a_etat_proprio', false)
                ->setParameter('c_etat_val', true)
                ->setParameter('c_etat_del', false)
                ->setParameter('c_etat_livraison', true)
                ->setParameter('c_etat_retour', false)
                ->setParameter('c_etat_reception', true);

        $query = $queryBuilder->getQuery();

        return $query->getSingleScalarResult();
    }

    /**
     * @return CommandeArticle[] Returns an array of Article objects
     */
    public function listeEnCours(?Article $article) {
        $queryBuilder = $this->createQueryBuilder('ca')
                ->leftJoin('ca.article', 'a')
                ->leftJoin('ca.commande', 'c')
                ->andWhere('ca.etat_val = :ca_etat_val')
                ->andWhere('ca.etat_del = :ca_etat_del')
                ->andWhere('c.etat_val = :c_etat_val')
                ->andWhere('c.etat_del = :c_etat_del')
                ->andWhere('c.etat_retour = :c_etat_retour')
                ->andWhere('c.etat_reception = :c_etat_reception')
                ->setParameter('ca_etat_val', true)
                ->setParameter('ca_etat_del', false)
                ->setParameter('c_etat_val', true)
                ->setParameter('c_etat_del', false)
                ->setParameter('c_etat_retour', false)
                ->setParameter('c_etat_reception', false);

        if ($article) {
            $queryBuilder->andWhere('ca.article = :article')
                    ->setParameter('article', $article);
        }

        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    /**
     * @return CommandeArticle[] Returns an array of Article objects
     */
    public function listeVenteInterne(?Article $article) {
        $queryBuilder = $this->createQueryBuilder('ca')
                ->leftJoin('ca.article', 'a')
                ->leftJoin('ca.commande', 'c')
                ->andWhere('ca.etat_val = :ca_etat_val')
                ->andWhere('ca.etat_del = :ca_etat_del')
                ->andWhere('a.etat_proprio = :a_etat_proprio')
                ->andWhere('c.etat_val = :c_etat_val')
                ->andWhere('c.etat_del = :c_etat_del')
                ->andWhere('c.etat_livraison = :c_etat_livraison')
                ->andWhere('c.etat_retour = :c_etat_retour')
                ->andWhere('c.etat_reception = :c_etat_reception')
                ->setParameter('ca_etat_val', true)
                ->setParameter('ca_etat_del', false)
                ->setParameter('a_etat_proprio', true)
                ->setParameter('c_etat_val', true)
                ->setParameter('c_etat_del', false)
                ->setParameter('c_etat_livraison', true)
                ->setParameter('c_etat_retour', false)
                ->setParameter('c_etat_reception', true);

        if ($article) {
            $queryBuilder->andWhere('ca.article = :article')
                    ->setParameter('article', $article);
        }
        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

}
