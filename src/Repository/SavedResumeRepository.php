<?php

namespace App\Repository;

use App\Entity\SavedResume;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SavedResume|null find($id, $lockMode = null, $lockVersion = null)
 * @method SavedResume|null findOneBy(array $criteria, array $orderBy = null)
 * @method SavedResume[]    findAll()
 * @method SavedResume[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SavedResumeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SavedResume::class);
    }

    // /**
    //  * @return SavedResume[] Returns an array of SavedResume objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SavedResume
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getSavedPaths() {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.user', 'u')
            ->addSelect('u')
            ->orderBy('s.id', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
}
