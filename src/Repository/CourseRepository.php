<?php

namespace App\Repository;

use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Course>
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    public function findByDepartmentSorted(string $department): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.department = :dep')
            ->setParameter('dep', $department)
            ->orderBy('c.yearOffered', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findPaged(int $limit, int $offset): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.name', 'ASC')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult();
    }

    public function findAdvanced(string $department, int $year): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.department = :dep')
            ->andWhere('c.yearOffered >= :year')
            ->setParameter('dep', $department)
            ->setParameter('year', $year)
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Course[] Returns an array of Course objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Course
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
