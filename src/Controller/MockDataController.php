<?php

namespace App\Controller;

use App\Entity\Exercise;
use App\Entity\ExerciseLog;
use App\Entity\Type;
use App\Entity\User;
use App\Entity\Workout;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class MockDataController extends AbstractController
{
    #[Route('/mock/data', name: 'app_mock_data')]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $user1 = new User();
        $user2 = new User();
        $user3 = new User();
        $user1->setName("John Doe");
        $user2->setName("Jeff Han");
        $user3->setName("Lara Bel");
        $user1->setPassword("strongPassword1");
        $user2->setPassword("strongPassword2");
        $user3->setPassword("strongPassword3");
        $entityManager->persist($user1);
        $entityManager->persist($user2);
        $entityManager->persist($user3);

        $workout1 = new Workout();
        $workout2 = new Workout();
        $workout3 = new Workout();
        $workout4 = new Workout();
        $workout5 = new Workout();
        $workout1->setName("Chest");
        $workout2->setName("Legs");
        $workout3->setName("Shoulders");
        $workout4->setName("Back");
        $workout5->setName("Core");
        $workout1->setDate((new \DateTime("now"))->modify('-7 days'));
        $workout2->setDate((new \DateTime("now"))->modify('-6 days'));
        $workout3->setDate((new \DateTime("now"))->modify('-5 days'));
        $workout4->setDate((new \DateTime("now"))->modify('-4 days'));
        $workout5->setDate((new \DateTime("now"))->modify('-3 days'));
        $workout1->setUser($user1);
        $workout2->setUser($user2);
        $workout3->setUser($user3);
        $workout4->setUser($user1);
        $workout5->setUser($user1);
        $entityManager->persist($workout1);
        $entityManager->persist($workout2);
        $entityManager->persist($workout3);
        $entityManager->persist($workout4);
        $entityManager->persist($workout5);


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
        $exercise3->setName("B.G.S.");
        $exercise4->setName("Shoulder press");
        $exercise5->setName("Pistol squats");
        $exercise6->setName("L sit");
        $exercise7->setName("Dips");
        $exercise8->setName("Pull-up");
        $exercise9->setName("Push-up");
        $exercise10->setName("Crunch");
        $entityManager->persist($exercise1);
        $entityManager->persist($exercise2);
        $entityManager->persist($exercise3);
        $entityManager->persist($exercise4);
        $entityManager->persist($exercise5);
        $entityManager->persist($exercise6);
        $entityManager->persist($exercise7);
        $entityManager->persist($exercise8);
        $entityManager->persist($exercise9);
        $entityManager->persist($exercise10);



        $type1 = new Type();
        $type2 = new Type();
        $type1->setName("weighted");
        $type2->setName("calisthenics");
        $entityManager->persist($type1);
        $entityManager->persist($type2);

        $exerciseLog1 = new ExerciseLog();
        $exerciseLog2 = new ExerciseLog();
        $exerciseLog1->setWorkout($workout1);
        $exerciseLog1->setExercise($exercise2);
        $exerciseLog1->setNrReps(10);
        $exerciseLog2->setWorkout($workout1);
        $exerciseLog2->setExercise($exercise9);
        $exerciseLog2->setNrReps(10);
        $entityManager->persist($exerciseLog1);
        $entityManager->persist($exerciseLog2);

        $entityManager->flush();


        return $this->json([
            'message' => 'Data was inserted successfully.',
        ]);
    }
}
