<?php

namespace App\DataFixtures;

use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $type1 = new Type();
        $type2 = new Type();
        $type1->setName("weighted");
        $type2->setName("calisthenics");
        $manager->persist($type1);
        $manager->persist($type2);

        $manager->flush();

        $this->addReference('type1', $type1);
        $this->addReference('type2', $type2);
    }
}
