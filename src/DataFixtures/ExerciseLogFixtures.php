<?php

namespace App\DataFixtures;

use App\Entity\ExerciseLog;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ExerciseLogFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $exerciseLog1 = new ExerciseLog();
        $exerciseLog2 = new ExerciseLog();
        $exerciseLog3 = new ExerciseLog();
        $exerciseLog4 = new ExerciseLog();
        $exerciseLog5 = new ExerciseLog();
        $exerciseLog6 = new ExerciseLog();
        $exerciseLog7 = new ExerciseLog();
        $exerciseLog8 = new ExerciseLog();
        $exerciseLog9 = new ExerciseLog();
        $exerciseLog10 = new ExerciseLog();
        $exerciseLog11 = new ExerciseLog();
        $exerciseLog12 = new ExerciseLog();
        $exerciseLog13 = new ExerciseLog();
        $exerciseLog14 = new ExerciseLog();
        $exerciseLog15 = new ExerciseLog();
        $exerciseLog16 = new ExerciseLog();

        $exerciseLog1->setWorkout($this->getReference("workout1"));
        $exerciseLog1->setExercise($this->getReference("exercise1"));
        $exerciseLog1->setNrReps(10);
        $exerciseLog1->setWeight(60);
        $exerciseLog2->setWorkout($this->getReference("workout1"));
        $exerciseLog2->setExercise($this->getReference("exercise1"));
        $exerciseLog2->setNrReps(10);
        $exerciseLog2->setWeight(60);
        $exerciseLog3->setWorkout($this->getReference("workout1"));
        $exerciseLog3->setExercise($this->getReference("exercise1"));
        $exerciseLog3->setNrReps(10);
        $exerciseLog3->setWeight(60);

        $exerciseLog4->setWorkout($this->getReference("workout1"));
        $exerciseLog4->setExercise($this->getReference("exercise2"));
        $exerciseLog4->setNrReps(8);
        $exerciseLog4->setWeight(15);
        $exerciseLog5->setWorkout($this->getReference("workout1"));
        $exerciseLog5->setExercise($this->getReference("exercise2"));
        $exerciseLog5->setNrReps(8);
        $exerciseLog5->setWeight(15);
        $exerciseLog6->setWorkout($this->getReference("workout1"));
        $exerciseLog6->setExercise($this->getReference("exercise2"));
        $exerciseLog6->setNrReps(8);
        $exerciseLog6->setWeight(15);

        $exerciseLog7->setWorkout($this->getReference("workout1"));
        $exerciseLog7->setExercise($this->getReference("exercise3"));
        $exerciseLog7->setNrReps(8);
        $exerciseLog7->setWeight(18);
        $exerciseLog8->setWorkout($this->getReference("workout1"));
        $exerciseLog8->setExercise($this->getReference("exercise3"));
        $exerciseLog8->setNrReps(8);
        $exerciseLog8->setWeight(18);
        $exerciseLog9->setWorkout($this->getReference("workout1"));
        $exerciseLog9->setExercise($this->getReference("exercise3"));
        $exerciseLog9->setNrReps(8);
        $exerciseLog9->setWeight(18);


        $exerciseLog10->setWorkout($this->getReference("workout1"));
        $exerciseLog10->setExercise($this->getReference("exercise4"));
        $exerciseLog10->setNrReps(10);
        $exerciseLog10->setWeight(72);
        $exerciseLog11->setWorkout($this->getReference("workout1"));
        $exerciseLog11->setExercise($this->getReference("exercise4"));
        $exerciseLog11->setNrReps(10);
        $exerciseLog11->setWeight(72);
        $exerciseLog12->setWorkout($this->getReference("workout1"));
        $exerciseLog12->setExercise($this->getReference("exercise4"));
        $exerciseLog12->setNrReps(10);
        $exerciseLog12->setWeight(72);

        $exerciseLog13->setWorkout($this->getReference("workout2"));
        $exerciseLog13->setExercise($this->getReference("exercise5"));
        $exerciseLog13->setNrReps(1);
        $exerciseLog13->setWeight(0);
        $exerciseLog13->setDuration(new \DateTime('today 01:00:00'));
        $exerciseLog14->setWorkout($this->getReference("workout2"));
        $exerciseLog14->setExercise($this->getReference("exercise6"));
        $exerciseLog14->setNrReps(1);
        $exerciseLog14->setWeight(0);
        $exerciseLog14->setDuration(new \DateTime('today 00:5:00'));
        $exerciseLog15->setWorkout($this->getReference("workout2"));
        $exerciseLog15->setExercise($this->getReference("exercise7"));
        $exerciseLog15->setNrReps(1);
        $exerciseLog15->setWeight(0);
        $exerciseLog15->setDuration(new \DateTime('today 00:5:00'));
        $exerciseLog16->setWorkout($this->getReference("workout2"));
        $exerciseLog16->setExercise($this->getReference("exercise8"));
        $exerciseLog16->setNrReps(1);
        $exerciseLog16->setWeight(0);
        $exerciseLog16->setDuration(new \DateTime('today 00:5:00'));

        $manager->persist($exerciseLog1);
        $manager->persist($exerciseLog2);
        $manager->persist($exerciseLog3);
        $manager->persist($exerciseLog4);
        $manager->persist($exerciseLog5);
        $manager->persist($exerciseLog6);
        $manager->persist($exerciseLog7);
        $manager->persist($exerciseLog8);
        $manager->persist($exerciseLog9);
        $manager->persist($exerciseLog10);
        $manager->persist($exerciseLog11);
        $manager->persist($exerciseLog12);
        $manager->persist($exerciseLog13);
        $manager->persist($exerciseLog14);
        $manager->persist($exerciseLog15);
        $manager->persist($exerciseLog16);

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            WorkoutFixtures::class,
            ExerciseFixtures::class,
        ];
    }
}