<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user2 = new User();
        $user3 = new User();

        $user1->setName("John Doe");
        $user2->setName("Jeff Han");
        $user3->setName("Alex Simion");

        $user1->setPassword("strongPassword1");
        $user2->setPassword("strongPassword2");
        $user3->setPassword("strongPassword3");

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($user3);

        $manager->flush();

        $this->addReference('user1', $user1);
        $this->addReference('user2', $user2);
        $this->addReference('user3', $user3);
    }
}