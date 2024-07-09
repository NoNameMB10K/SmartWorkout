<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $entityManager;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, User::class);
        $this->entityManager = $entityManager;
    }
    public function saveOne(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
    public function findOneByName(string $name): User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.name = :val')
            ->setParameter('val', $name)
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findOneByMail(string $email): User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :email')
            ->setParameter('email', $email)
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function findOneById(int $id): User
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
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?User
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
