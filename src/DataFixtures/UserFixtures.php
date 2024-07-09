<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;
    public function __construct(UserPasswordHasherInterface $userPasswordHasher){
        $this->userPasswordHasher = $userPasswordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user2 = new User();
        $user3 = new User();

        $user1->setName("John Doe");
        $user2->setName("Jeff Han");
        $user3->setName("Alex Simion");
        $user1->setPassword($this->userPasswordHasher->hashPassword($user1, "john"));
        $user2->setPassword($this->userPasswordHasher->hashPassword($user2, "jeff"));
        $user3->setPassword($this->userPasswordHasher->hashPassword($user3, "alex"));

        $user1->setEmail("john@mail.com");
        $user2->setEmail("jeff@mail.com");
        $user3->setEmail("alex@mail.com");

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($user3);

        $manager->flush();

        $this->addReference('user1', $user1);
        $this->addReference('user2', $user2);
        $this->addReference('user3', $user3);
    }
}