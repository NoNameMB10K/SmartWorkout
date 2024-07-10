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
        $exercise9 = new Exercise();
        $exercise10 = new Exercise();

        $exercise1->setName("Bench Press");
        $exercise2->setName("Biceps Curls");
        $exercise3->setName("Triceps Cable Extension");
        $exercise4->setName("Dips");


        $exercise1->setLinkToVideo("4Y2ZdHCOXok");
        $exercise2->setLinkToVideo("jjnJHhzZUUM");
        $exercise3->setLinkToVideo("3jxrjl4B8-U");
        $exercise4->setLinkToVideo("l41SoWZiowI");


        $exercise1->setType($this->getReference('type1'));
        $exercise2->setType($this->getReference('type3'));
        $exercise3->setType($this->getReference('type2'));
        $exercise4->setType($this->getReference('type1'));


        $exercise1->setUser($this->getReference('user3'));
        $exercise2->setUser($this->getReference('user3'));
        $exercise3->setUser($this->getReference('user3'));
        $exercise4->setUser($this->getReference('user3'));

        $manager->persist($exercise1);
        $manager->persist($exercise2);
        $manager->persist($exercise3);
        $manager->persist($exercise4);

        $manager->flush();

        $this->addReference('exercise1', $exercise1);
        $this->addReference('exercise2', $exercise2);
        $this->addReference('exercise3', $exercise3);
        $this->addReference('exercise4', $exercise4);
    }

    public function getDependencies(): array
    {
        return [
            TypeFixtures::class,
            UserFixtures::class,
        ];
    }
}