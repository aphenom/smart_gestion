<?php

namespace App\Repository;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Commande::class);
    }

    // /**
    //  * @return Commande[] Returns an array of Commande objects
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
      public function findOneBySomeField($value): ?Commande
      {
      return $this->createQueryBuilder('c')
      ->andWhere('c.exampleField = :val')
      ->setParameter('val', $value)
      ->getQuery()
      ->getOneOrNullResult()
      ;
      }
     */

    public function nonValide(): ?int {
        return $this->createQueryBuilder('c')
                        ->select('COUNT(c.id)')
                        ->andWhere('c.etat_val = :etat_val')
                        ->setParameter('etat_val', false)
                        ->getQuery()
                        ->getSingleScalarResult()
        ;
    }

    public function livraisonAttente(): ?int {
        return $this->createQueryBuilder('c')
                        ->select('COUNT(c.id)')
                        ->andWhere('c.etat_livraison = :etat_livraison')
                        ->andWhere('c.etat_val = :etat_val')
                        ->andWhere('c.etat_del = :etat_del')
                        ->setParameter('etat_livraison', false)
                        ->setParameter('etat_val', true)
                        ->setParameter('etat_del', false)
                        ->getQuery()
                        ->getSingleScalarResult()
        ;
    }

    public function livraisonCours(): ?int {
        return $this->createQueryBuilder('c')
                        ->select('COUNT(c.id)')
                        ->andWhere('c.etat_livraison = :etat_livraison')
                        ->andWhere('c.etat_retour = :etat_retour')
                        ->andWhere('c.etat_reception = :etat_reception')
                        ->andWhere('c.etat_val = :etat_val')
                        ->andWhere('c.etat_del = :etat_del')
                        ->setParameter('etat_livraison', true)
                        ->setParameter('etat_retour', false)
                        ->setParameter('etat_reception', false)
                        ->setParameter('etat_val', true)
                        ->setParameter('etat_del', false)
                        ->getQuery()
                        ->getSingleScalarResult()
        ;
    }

    public function livraisonRetour(): ?int {
        return $this->createQueryBuilder('c')
                        ->select('COUNT(c.id)')
                        ->andWhere('c.etat_livraison = :etat_livraison')
                        ->andWhere('c.etat_retour = :etat_retour')
                        ->andWhere('c.etat_reception = :etat_reception')
                        ->andWhere('c.etat_val = :etat_val')
                        ->andWhere('c.etat_del = :etat_del')
                        ->setParameter('etat_livraison', true)
                        ->setParameter('etat_retour', true)
                        ->setParameter('etat_reception', false)
                        ->setParameter('etat_val', true)
                        ->setParameter('etat_del', false)
                        ->getQuery()
                        ->getSingleScalarResult()
        ;
    }

    public function livraisonReception(): ?int {
        return $this->createQueryBuilder('c')
                        ->select('COUNT(c.id)')
                        ->andWhere('c.etat_livraison = :etat_livraison')
                        ->andWhere('c.etat_retour = :etat_retour')
                        ->andWhere('c.etat_reception = :etat_reception')
                        ->andWhere('c.etat_val = :etat_val')
                        ->andWhere('c.etat_del = :etat_del')
                        ->setParameter('etat_livraison', true)
                        ->setParameter('etat_retour', false)
                        ->setParameter('etat_reception', true)
                        ->setParameter('etat_val', true)
                        ->setParameter('etat_del', false)
                        ->getQuery()
                        ->getSingleScalarResult()
        ;
    }

    /**
     * @return Commande[] Returns an array of Commande objects
     */
    public function listeNonValide() {
        return $this->createQueryBuilder('c')
                        ->andWhere('c.etat_val = :etat_val')
                        ->setParameter('etat_val', false)
                        ->orderBy('c.id', 'DESC')
                        ->getQuery()
                        ->getResult()
        ;
    }

    /**
     * @return Commande[] Returns an array of Commande objects
     */
    public function listeLivraisonAttente() {
        return $this->createQueryBuilder('c')
                        ->andWhere('c.etat_livraison = :etat_livraison')
                        ->andWhere('c.etat_val = :etat_val')
                        ->andWhere('c.etat_del = :etat_del')
                        ->setParameter('etat_livraison', false)
                        ->setParameter('etat_val', true)
                        ->setParameter('etat_del', false)
                        ->orderBy('c.id', 'DESC')
                        ->getQuery()
                        ->getResult()
        ;
    }

    /**
     * @return Commande[] Returns an array of Commande objects
     */
    public function listeLivraisonCours() {
        return $this->createQueryBuilder('c')
                        ->andWhere('c.etat_livraison = :etat_livraison')
                        ->andWhere('c.etat_retour = :etat_retour')
                        ->andWhere('c.etat_reception = :etat_reception')
                        ->andWhere('c.etat_val = :etat_val')
                        ->andWhere('c.etat_del = :etat_del')
                        ->setParameter('etat_livraison', true)
                        ->setParameter('etat_retour', false)
                        ->setParameter('etat_reception', false)
                        ->setParameter('etat_val', true)
                        ->setParameter('etat_del', false)
                        ->orderBy('c.id', 'DESC')
                        ->getQuery()
                        ->getResult()
        ;
    }

    /**
     * @return Commande[] Returns an array of Commande objects
     */
    public function listeLivraisonRetour() {
        return $this->createQueryBuilder('c')
                        ->andWhere('c.etat_livraison = :etat_livraison')
                        ->andWhere('c.etat_retour = :etat_retour')
                        ->andWhere('c.etat_reception = :etat_reception')
                        ->andWhere('c.etat_val = :etat_val')
                        ->andWhere('c.etat_del = :etat_del')
                        ->setParameter('etat_livraison', true)
                        ->setParameter('etat_retour', true)
                        ->setParameter('etat_reception', false)
                        ->setParameter('etat_val', true)
                        ->setParameter('etat_del', false)
                        ->orderBy('c.id', 'DESC')
                        ->getQuery()
                        ->getResult()
        ;
    }

    /**
     * @return Commande[] Returns an array of Commande objects
     */
    public function listeLivraisonReception() {
        return $this->createQueryBuilder('c')
                        ->andWhere('c.etat_livraison = :etat_livraison')
                        ->andWhere('c.etat_retour = :etat_retour')
                        ->andWhere('c.etat_reception = :etat_reception')
                        ->andWhere('c.etat_val = :etat_val')
                        ->andWhere('c.etat_del = :etat_del')
                        ->setParameter('etat_livraison', true)
                        ->setParameter('etat_retour', false)
                        ->setParameter('etat_reception', true)
                        ->setParameter('etat_val', true)
                        ->setParameter('etat_del', false)
                        ->orderBy('c.id', 'DESC')
                        ->getQuery()
                        ->getResult()
        ;
    }

}
