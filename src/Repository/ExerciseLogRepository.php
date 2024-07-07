<?php

namespace App\Repository;

use App\Entity\Exercise;
use App\Entity\ExerciseLog;
use App\Entity\Workout;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExerciseLog>
 */
class ExerciseLogRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $entityManager;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, ExerciseLog::class);
        $this->entityManager = $entityManager;
    }

    public function findByWorkoutId(int $workoutId): ?array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.workout = :givenId')
            ->setParameter('givenId', $workoutId)
            ->leftJoin('e.exercise', 'ex')
            ->addSelect('ex')
            ->leftJoin('ex.type', 't')
            ->addSelect('t')
            ->getQuery()
            ->getResult()
        ;
    }

    public function saveOne(ExerciseLog $exerciseLog): void
    {
        $this->entityManager->persist($exerciseLog);
        $this->entityManager->flush();
    }

    public function deleteOneById(int $id): void
    {
        $this->createQueryBuilder('u')
            ->delete()
            ->where('u.id = :givenId')
            ->setParameter('givenId', $id)
            ->getQuery()
            ->getResult()
        ;
    }

    public function exerciseIsUsed(Exercise $exercise): bool
    {
        $ans = $this->createQueryBuilder('u')
            ->where('u.exercise = :exercise')
            ->setParameter('exercise', $exercise)
            ->getQuery()
            ->getResult()
        ;
        if(!empty($ans))
            return false;
        else
            return true;
    }

    public function deleteWorkoutEntries(Workout $workout): void
    {
        $this->createQueryBuilder('u')
            ->delete()
            ->where('u.workout = :workout')
            ->setParameter('workout', $workout)
            ->getQuery()
            ->execute();
    }


    public function findOneById(int $id): ExerciseLog
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.id = :givenId')
            ->setParameter('givenId', $id)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    //    /**
    //     * @return ExerciseLog[] Returns an array of ExerciseLog objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ExerciseLog
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
