<?php

namespace App\Repository;

use App\Entity\ListingPicture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ListingPicture|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListingPicture|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListingPicture[]    findAll()
 * @method ListingPicture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListingPictureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListingPicture::class);
    }

    // /**
    //  * @return ListingPicture[] Returns an array of ListingPicture objects
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
    public function findOneBySomeField($value): ?ListingPicture
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
