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
                'action' => 'created',
                'entity' => "Exercise",
            ]);
        }

        return $this->render('exercise/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/exercises', methods: ['GET'])]
    public function show(ExerciseRepository $exerciseRepository): Response
    {
        return $this->render('exercise/show.html.twig', ['exercises' => $exerciseRepository->findAll()]);
    }

    #[Route('/exercise/{id}', name:'exercise_edit', requirements: ['id' => '^\d+$'], methods: ['GET', 'PATCH'])]
    public function edit(int $id,Request $request, ExerciseRepository $exerciseRepository): Response
    {
        $exercise = $exerciseRepository->findOneById($id);
        $form = $this->createForm(ExerciseType::class, $exercise, [
            'action' => $this->generateUrl('exercise_edit', ['id' => $id]),
            'method' => 'PATCH',
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //$exerciseRepository->saveOne($user);
            return $this->render('finishedActionPrompt.html.twig', [
                'entity' => 'Exercise',
                'action' => 'updated',
                'success' => true,
            ]);
        }

        return $this->render('exercise/edit.html.twig', [
            'form' => $form,
        ]);
    }

}
