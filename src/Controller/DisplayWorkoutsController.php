<?php

namespace App\Controller;


use App\Repository\WorkoutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DisplayWorkoutsController extends AbstractController
{
    #[Route('/display/workouts', name: 'app_display_workouts')]
    public function index(WorkoutRepository $workoutRepository): Response
    {
        //dd($workoutRepository->findAll());
        return $this->render('workouts.html.twig', ['workouts' => $workoutRepository->findAll()]);
    }
}
