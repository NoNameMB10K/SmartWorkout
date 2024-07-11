<?php

namespace App\DataFixtures;

use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TypeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $type1 = new Type();
        $type2 = new Type();
        $type3 = new Type();
        $type1->setName("chest");
        $type2->setName("triceps");
        $type3->setName("biceps");
        $type1->setUser($this->getReference('user3'));
        $type2->setUser($this->getReference('user3'));
        $type3->setUser($this->getReference('user3'));

        $type4 = new Type();
        $type5 = new Type();
        $type6 = new Type();
        $type4->setName("Cardio");
        $type5->setName("Calisthenics");
        $type6->setName("Stretching");
        $type4->setUser($this->getReference('user3'));
        $type5->setUser($this->getReference('user3'));
        $type6->setUser($this->getReference('user3'));


        $manager->persist($type1);
        $manager->persist($type2);
        $manager->persist($type3);
        $manager->persist($type4);
        $manager->persist($type5);
        $manager->persist($type6);

        $manager->flush();

        $this->addReference('type1', $type1);
        $this->addReference('type2', $type2);
        $this->addReference('type3', $type3);
        $this->addReference('type4', $type4);
        $this->addReference('type5', $type5);
        $this->addReference('type6', $type6);
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
