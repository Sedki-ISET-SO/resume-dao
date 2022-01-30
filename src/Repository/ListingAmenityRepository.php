<?php

namespace App\Repository;

use App\Entity\ListingAmenity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ListingAmenity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListingAmenity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListingAmenity[]    findAll()
 * @method ListingAmenity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListingAmenityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListingAmenity::class);
    }

    // /**
    //  * @return ListingAmenity[] Returns an array of ListingAmenity objects
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
    public function findOneBySomeField($value): ?ListingAmenity
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
