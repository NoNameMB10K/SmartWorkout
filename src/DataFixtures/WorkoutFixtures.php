<?php

namespace App\DataFixtures;

use App\Entity\Type;
use App\Entity\Workout;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class WorkoutFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $workout1 = new Workout();
        $workout1->setName("Chest And Arms");
        $workout1->setDate((new \DateTime("now"))->modify('-7 days'));
        $workout1->setUser($this->getReference('user3'));

        $manager->persist($workout1);
        $manager->flush();

        $this->addReference('workout1', $workout1);
    }
    public function getDependencies(): array
    {
        return [
            TypeFixtures::class,
            UserFixtures::class,
        ];
    }
}