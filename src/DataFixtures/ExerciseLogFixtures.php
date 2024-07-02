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

        $exerciseLog1->setWorkout($this->getReference("workout1"));
        $exerciseLog1->setExercise($this->getReference("exercise2"));
        $exerciseLog1->setNrReps(10);
        $exerciseLog2->setWorkout($this->getReference("workout1"));
        $exerciseLog2->setExercise($this->getReference("exercise2"));
        $exerciseLog2->setNrReps(10);
        $exerciseLog3->setWorkout($this->getReference("workout1"));
        $exerciseLog3->setExercise($this->getReference("exercise2"));
        $exerciseLog3->setNrReps(10);


        $exerciseLog4->setWorkout($this->getReference("workout4"));
        $exerciseLog4->setExercise($this->getReference("exercise1"));
        $exerciseLog4->setNrReps(10);
        $exerciseLog5->setWorkout($this->getReference("workout4"));
        $exerciseLog5->setExercise($this->getReference("exercise1"));
        $exerciseLog5->setNrReps(10);
        $exerciseLog6->setWorkout($this->getReference("workout4"));
        $exerciseLog6->setExercise($this->getReference("exercise1"));
        $exerciseLog6->setNrReps(10);


        $exerciseLog7->setWorkout($this->getReference("workout2"));
        $exerciseLog7->setExercise($this->getReference("exercise9"));
        $exerciseLog7->setNrReps(10);
        $exerciseLog8->setWorkout($this->getReference("workout2"));
        $exerciseLog8->setExercise($this->getReference("exercise9"));
        $exerciseLog8->setNrReps(10);
        $exerciseLog9->setWorkout($this->getReference("workout2"));
        $exerciseLog9->setExercise($this->getReference("exercise9"));
        $exerciseLog9->setNrReps(10);

        $exerciseLog10->setWorkout($this->getReference("workout2"));
        $exerciseLog10->setExercise($this->getReference("exercise7"));
        $exerciseLog10->setNrReps(10);
        $exerciseLog11->setWorkout($this->getReference("workout2"));
        $exerciseLog11->setExercise($this->getReference("exercise7"));
        $exerciseLog11->setNrReps(10);
        $exerciseLog12->setWorkout($this->getReference("workout2"));
        $exerciseLog12->setExercise($this->getReference("exercise7"));
        $exerciseLog12->setNrReps(10);

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