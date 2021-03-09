<?php

namespace App\Repository;

use App\Entity\Bookcase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bookcase|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bookcase|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bookcase[]    findAll()
 * @method Bookcase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookcaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bookcase::class);
    }

    // /**
    //  * @return Bookcase[] Returns an array of Bookcase objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bookcase
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
