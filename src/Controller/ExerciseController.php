<?php

namespace App\Controller;

use App\Entity\Exercise;
use App\Form\Type\ExerciseType;
use App\Repository\ExerciseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExerciseController extends AbstractController
{
    #[Route('/exercise', methods: ['GET','POST'])]
    public function new(Request $request, ExerciseRepository $exerciseRepository): Response
    {
        $exercise = new Exercise();
        $exercise->setName('');

        $form = $this->createForm(ExerciseType::class, $exercise);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //$exerciseRepository->saveOne($exercise);
            return $this->render('finishedActionPrompt.html.twig', [
                'success' => true,
                'entity' => "Exercise",
            ]);
        }

        return $this->render('exercise/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/exercises', methods: ['GET'])]
    public function index(ExerciseRepository $exerciseRepository): Response
    {
        return $this->render('exercise/show.html.twig', ['exercises' => $exerciseRepository->findAll()]);
    }

}
