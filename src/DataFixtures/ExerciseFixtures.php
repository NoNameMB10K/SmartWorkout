<?php

namespace App\DataFixtures;

use App\Entity\Exercise;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ExerciseFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $exercise1 = new Exercise();
        $exercise2 = new Exercise();
        $exercise3 = new Exercise();
        $exercise4 = new Exercise();
        $exercise5 = new Exercise();
        $exercise6 = new Exercise();
        $exercise7 = new Exercise();
        $exercise8 = new Exercise();

        $exercise1->setName("Bench Press");
        $exercise2->setName("Biceps Curls");
        $exercise3->setName("Triceps Cable Extension");
        $exercise4->setName("Dips");
        $exercise5->setName("Rowing Cardio");
        $exercise6->setName("L Sit");
        $exercise7->setName("Calf Stretch");
        $exercise8->setName("The Splits");

        $exercise1->setLinkToVideo("4Y2ZdHCOXok");
        $exercise2->setLinkToVideo("jjnJHhzZUUM");
        $exercise3->setLinkToVideo("3jxrjl4B8-U");
        $exercise4->setLinkToVideo("l41SoWZiowI");
        $exercise5->setLinkToVideo("dPezGjAhrU0");
        $exercise6->setLinkToVideo("jWyD_Ri93YE");
        $exercise7->setLinkToVideo("kVnp2-YH3k4");
        $exercise8->setLinkToVideo("OeJSgrqIxVc");

        $exercise1->setType($this->getReference('type1'));
        $exercise2->setType($this->getReference('type3'));
        $exercise3->setType($this->getReference('type2'));
        $exercise4->setType($this->getReference('type1'));
        $exercise5->setType($this->getReference('type4'));
        $exercise6->setType($this->getReference('type5'));
        $exercise7->setType($this->getReference('type6'));
        $exercise8->setType($this->getReference('type6'));

        $exercise1->setUser($this->getReference('user3'));
        $exercise2->setUser($this->getReference('user3'));
        $exercise3->setUser($this->getReference('user3'));
        $exercise4->setUser($this->getReference('user3'));
        $exercise5->setUser($this->getReference('user3'));
        $exercise6->setUser($this->getReference('user3'));
        $exercise7->setUser($this->getReference('user3'));
        $exercise8->setUser($this->getReference('user3'));

        $manager->persist($exercise1);
        $manager->persist($exercise2);
        $manager->persist($exercise3);
        $manager->persist($exercise4);
        $manager->persist($exercise5);
        $manager->persist($exercise6);
        $manager->persist($exercise7);
        $manager->persist($exercise8);

        $manager->flush();

        $this->addReference('exercise1', $exercise1);
        $this->addReference('exercise2', $exercise2);
        $this->addReference('exercise3', $exercise3);
        $this->addReference('exercise4', $exercise4);
        $this->addReference('exercise5', $exercise5);
        $this->addReference('exercise6', $exercise6);
        $this->addReference('exercise7', $exercise7);
        $this->addReference('exercise8', $exercise8);
    }

    public function getDependencies(): array
    {
        return [
            TypeFixtures::class,
            UserFixtures::class,
        ];
    }
}