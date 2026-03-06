<?php

namespace App\Repository;

use App\Entity\Schedule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Schedule>
 */
class ScheduleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Schedule::class);
    }

    public function countSchedulesPerCourse(): array
    {
        return $this->createQueryBuilder('s')
            ->select('c.name AS name, COUNT(s.id) AS total')
            ->join('s.course', 'c')
            ->groupBy('c.id')
            ->getQuery()
            ->getResult();
    }

    public function countSchedulesPerTeacher()
    {
        return $this->createQueryBuilder('s')
            ->select('s.teacher, COUNT(s.id) as total')
            ->groupBy('s.teacher')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Schedule[] Returns an array of Schedule objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Schedule
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
