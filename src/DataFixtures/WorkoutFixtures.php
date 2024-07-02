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
        $workout2 = new Workout();
        $workout3 = new Workout();
        $workout4 = new Workout();
        $workout5 = new Workout();

        $workout1->setName("Chest weighted");
        $workout2->setName("Chest calisthenics");
        $workout3->setName("Shoulders weighted");
        $workout4->setName("Back weighted");
        $workout5->setName("Core calisthenics");

        $workout1->setDate((new \DateTime("now"))->modify('-7 days'));
        $workout2->setDate((new \DateTime("now"))->modify('-6 days'));
        $workout3->setDate((new \DateTime("now"))->modify('-5 days'));
        $workout4->setDate((new \DateTime("now"))->modify('-4 days'));
        $workout5->setDate((new \DateTime("now"))->modify('-3 days'));

        $workout1->setUser($this->getReference('user3'));
        $workout2->setUser($this->getReference('user3'));
        $workout3->setUser($this->getReference('user3'));
        $workout4->setUser($this->getReference('user3'));
        $workout5->setUser($this->getReference('user3'));

        $workout1->setType($this->getReference('type1'));
        $workout2->setType($this->getReference('type2'));
        $workout3->setType($this->getReference('type1'));
        $workout4->setType($this->getReference('type1'));
        $workout5->setType($this->getReference('type2'));

        $manager->persist($workout1);
        $manager->persist($workout2);
        $manager->persist($workout3);
        $manager->persist($workout4);
        $manager->persist($workout5);

        $manager->flush();

        $this->addReference('workout1', $workout1);
        $this->addReference('workout2', $workout2);
        $this->addReference('workout3', $workout3);
        $this->addReference('workout4', $workout4);
        $this->addReference('workout5', $workout5);
    }
    public function getDependencies(): array
    {
        return [
            TypeFixtures::class,
            UserFixtures::class,
        ];
    }
}