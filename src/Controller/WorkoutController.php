<?php

namespace App\Controller;


use App\Repository\WorkoutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WorkoutController extends AbstractController
{
    #[Route('/workouts', name: 'app_display_workouts', methods: ['GET'])]
    public function index(WorkoutRepository $workoutRepository): Response
    {
        return $this->render('workout/show.html.twig', ['workouts' => $workoutRepository->findAll()]);
    }
}
