<?php

namespace App\Repository;

use App\Entity\MessageExterne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MessageExterne|null find($id, $lockMode = null, $lockVersion = null)
 * @method MessageExterne|null findOneBy(array $criteria, array $orderBy = null)
 * @method MessageExterne[]    findAll()
 * @method MessageExterne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageExterneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MessageExterne::class);
    }

    // /**
    //  * @return MessageExterne[] Returns an array of MessageExterne objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MessageExterne
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
