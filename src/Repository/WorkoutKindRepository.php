<?php

namespace App\Repository;

use App\Entity\WorkoutKind;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WorkoutKind|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkoutKind|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkoutKind[]    findAll()
 * @method WorkoutKind[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkoutKindRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkoutKind::class);
    }

    // /**
    //  * @return WorkoutKind[] Returns an array of WorkoutKind objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WorkoutKind
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
