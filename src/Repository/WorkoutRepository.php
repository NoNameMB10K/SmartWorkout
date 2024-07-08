<?php

namespace App\Repository;

use App\Entity\Type;
use App\Entity\User;
use App\Entity\Workout;
use App\Repository\Typee as TypeeAlias;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Workout>
 */
class WorkoutRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $entityManager;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Workout::class);
        $this->entityManager = $entityManager;
    }

    public function findAll(): array
    {
        return $this->createQueryBuilder('w')
                ->orderBy('w.id', 'ASC')
                ->getQuery()
                ->getResult()
            ;
    }

    public function findAllByUserId(User $suer): array
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.user = :user')
            ->setParameter('user', $suer)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllByType(Type $type): array
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.type = :type')
            ->setParameter('type', $type)
            ->getQuery()
            ->getResult()
            ;
    }

    public function saveOne(Workout $workout): void
    {
        $this->entityManager->persist($workout);
        $this->entityManager->flush();
    }

    public function findOneById(int $id): ?Workout
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
    //     * @return Workout[] Returns an array of Workout objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('w.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Workout
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
