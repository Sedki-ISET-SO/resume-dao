<?php

namespace App\Repository;

use App\Entity\ListingAvailability;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ListingAvailability|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListingAvailability|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListingAvailability[]    findAll()
 * @method ListingAvailability[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListingAvailabilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListingAvailability::class);
    }

    // /**
    //  * @return ListingAvailability[] Returns an array of ListingAvailability objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ListingAvailability
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
