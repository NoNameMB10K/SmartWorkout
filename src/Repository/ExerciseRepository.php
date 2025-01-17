<?php

namespace App\Repository;

use App\Entity\Exercise;
use App\Entity\Type;
use App\Entity\User;
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

    public function findAllByUserId(User $user): array
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findOneById(int $id): Exercise
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.id = :givenId')
            ->setParameter('givenId', $id)
            ->setMaxResults(10)
            ->getQuery()
            ->getOneOrNullResult()
            ;
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

    public function typeIsUsed(Type $type): bool
    {
        $ans = $this->createQueryBuilder('u')
            ->where('u.type = :type')
            ->setParameter('type', $type)
            ->getQuery()
            ->getResult()
        ;
        if(!empty($ans))
            return false;
        else
            return true;
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
