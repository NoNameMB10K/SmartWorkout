<?php

namespace App\DataFixtures;

use App\Entity\Exercise;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ExerciseFixtures extends Fixture
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

        $exercise1->setName("Rows");
        $exercise2->setName("Bench press");
        $exercise3->setName("B.G.S");
        $exercise4->setName("Shoulder press");
        $exercise5->setName("Pistol squats");
        $exercise6->setName("L sit");
        $exercise7->setName("Dips");
        $exercise8->setName("Pull-up");
        $exercise9->setName("Push-up");
        $exercise10->setName("Crunch");

        $exercise1->setLinkToVideo("https://www.youtube.com/watch?v=dPezGjAhrU0&t=20s");
        $exercise2->setLinkToVideo("https://www.youtube.com/watch?v=4Y2ZdHCOXok");
        $exercise3->setLinkToVideo("https://www.youtube.com/watch?v=SkNsa3eBwLA");
        $exercise4->setLinkToVideo("https://www.youtube.com/watch?v=boUVD0pCGCk");
        $exercise5->setLinkToVideo("https://www.youtube.com/watch?v=vq5-vdgJc0I");
        $exercise6->setLinkToVideo("https://www.youtube.com/watch?v=wuDgmAr2ez8");
        $exercise7->setLinkToVideo("https://www.youtube.com/watch?v=l41SoWZiowI");
        $exercise8->setLinkToVideo("https://www.youtube.com/watch?v=p40iUjf02j0&t=104s");
        $exercise9->setLinkToVideo("https://www.youtube.com/watch?v=IODxDxX7oi4");
        $exercise10->setLinkToVideo("https://www.youtube.com/watch?v=MKmrqcoCZ-M");

        $exercise1->setType($this->getReference('type1'));
        $exercise2->setType($this->getReference('type1'));
        $exercise3->setType($this->getReference('type1'));
        $exercise4->setType($this->getReference('type1'));
        $exercise5->setType($this->getReference('type2'));
        $exercise6->setType($this->getReference('type1'));
        $exercise7->setType($this->getReference('type2'));
        $exercise8->setType($this->getReference('type2'));
        $exercise9->setType($this->getReference('type2'));
        $exercise10->setType($this->getReference('type2'));

        $manager->persist($exercise1);
        $manager->persist($exercise2);
        $manager->persist($exercise3);
        $manager->persist($exercise4);
        $manager->persist($exercise5);
        $manager->persist($exercise6);
        $manager->persist($exercise7);
        $manager->persist($exercise8);
        $manager->persist($exercise9);
        $manager->persist($exercise10);

        $manager->flush();

        $this->addReference('exercise1', $exercise1);
        $this->addReference('exercise2', $exercise2);
        $this->addReference('exercise3', $exercise3);
        $this->addReference('exercise4', $exercise4);
        $this->addReference('exercise5', $exercise5);
        $this->addReference('exercise6', $exercise6);
        $this->addReference('exercise7', $exercise7);
        $this->addReference('exercise8', $exercise8);
        $this->addReference('exercise9', $exercise9);
        $this->addReference('exercise10', $exercise10);
    }
}