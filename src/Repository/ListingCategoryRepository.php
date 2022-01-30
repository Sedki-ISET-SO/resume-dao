<?php

namespace App\Repository;

use App\Entity\ListingCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ListingCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListingCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListingCategory[]    findAll()
 * @method ListingCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListingCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListingCategory::class);
    }

    // /**
    //  * @return ListingCategory[] Returns an array of ListingCategory objects
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
    public function findOneBySomeField($value): ?ListingCategory
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getCategories() {
        return $this->createQueryBuilder('c')
            ->addSelect('c')
            ->orderBy('c.id', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getSingleCategory(int $id) {
        return $this->createQueryBuilder('c')
            ->addSelect('u')
            ->where('c.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
