<?php

namespace App\Repository;

use App\Entity\Exercise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Exercise>
 */
class ExerciseRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Exercise::class);
        $this->entityManager = $entityManager;
    }

    public function saveOne(Exercise $exercise): void
    {
        $this->entityManager->persist($exercise);
        $this->entityManager->flush();
    }

    public function findOneById(int $id): Exercise
    {
        $response = $this->createQueryBuilder('u')
            ->andWhere('u.id = :givenId')
            ->setParameter('givenId', $id)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
        return $response[0];
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


    //    /**
    //     * @return Exercise[] Returns an array of Exercise objects
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

    //    public function findOneBySomeField($value): ?Exercise
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
