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

        $user3 = new User();
        $user3->setName("Alex Simion");
        $user3->setPassword($this->userPasswordHasher->hashPassword($user3, "alexsimion"));
        $user3->setEmail("alex@mail.com");

        $manager->persist($user3);
        $manager->flush();

        $this->addReference('user3', $user3);
    }
}