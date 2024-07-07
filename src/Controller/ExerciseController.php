<?php

namespace App\Controller;

use App\Entity\Exercise;
use App\Form\Type\DeleteButtonType;
use App\Form\Type\ExerciseType;
use App\Repository\ExerciseLogRepository;
use App\Repository\ExerciseRepository;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExerciseController extends AbstractController
{
    #[Route('/exercises', name:'exercises_index', methods: ['GET'])]
    public function index(ExerciseRepository $exerciseRepository): Response
    {
        return $this->render('exercise/index.html.twig', ['exercises' => $exerciseRepository->findAll()]);
    }
    #[Route('/exercises/new',name:'exercises_new', methods: ['GET'])]
    public function new(): Response
    {
        $exercise = new Exercise();
        $form = $this->createForm(ExerciseType::class, $exercise, [
            'action' => $this->generateUrl('exercises_create'),
            'method' => 'POST'
        ]);

        return $this->render('exercise/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/exercises',name:'exercises_create', methods: ['POST'])]
    public function create(Request $request, ExerciseRepository $exerciseRepository): Response
    {
        $exercise = new Exercise();

        $form = $this->createForm(ExerciseType::class, $exercise);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $exerciseRepository->saveOne($exercise);
            return $this->redirectToRoute('exercises_index');
//            return $this->render('finishedActionPrompt.html.twig', [
//                'success' => true,
//                'action' => 'created',
//                'entity' => "Exercise",
//            ]);
        }

        ////////////////////////////////////////////////
        return $this->render('finishedActionPrompt.html.twig', [
            'entity' => 'Exercise-error',
            'action' => 'Created',
            'success' => true,
        ]);
    }

    #[Route('/exercise/{id}', name:'exercise_show', requirements: ['id' => '^\d+$'], methods: ['GET'])]
    public function show(int $id, ExerciseRepository $exerciseRepository): Response
    {
        $exercise = $exerciseRepository->findOneById($id);

        return $this->render('exercise/show.html.twig', [
            'exercise' => $exercise,
        ]);
    }

    #[Route('/exercise/edit/{id}', name:'exercise_edit', requirements: ['id' => '^\d+$'], methods: ['GET'])]
    public function edit(int $id, ExerciseRepository $exerciseRepository, ExerciseLogRepository $exerciseLogRepository): Response
    {
        $exercise = $exerciseRepository->findOneById($id);
        $editForm = $this->createForm(ExerciseType::class, $exercise, [
            'action' => $this->generateUrl('exercise_update', ['id' => $id]),
            'method' => 'PATCH',
        ]);

        $deleteForm = $this->createForm(DeleteButtonType::class, new stdClass(), [
            'action' => $this->generateUrl('exercise_delete', ['id' => $id]),
            'method' => 'DELETE',
        ]);

        $deletable = $exerciseLogRepository->exerciseIsUsed($exercise);

        return $this->render('exercise/edit.html.twig', [
            'editForm' => $editForm,
            'deleteFrom' => $deleteForm,
            'deletable' => $deletable,
        ]);
    }
    #[Route('/exercise/{id}', name:'exercise_update', requirements: ['id' => '^\d+$'], methods: ['PATCH'])]
    public function update(int $id,Request $request, ExerciseRepository $exerciseRepository): Response
    {
        $exercise = $exerciseRepository->findOneById($id);
        $form = $this->createForm(ExerciseType::class, $exercise, [
            'action' => $this->generateUrl('exercise_update', ['id' => $id]),
            'method' => 'PATCH',
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $exerciseRepository->saveOne($exercise);
            return $this->redirectToRoute('exercises_index');
//            return $this->render('finishedActionPrompt.html.twig', [
//                'entity' => 'Exercise',
//                'action' => 'updated',
//                'success' => true,
//            ]);
        }

        ////////////////////////////////////////////////
        return $this->render('finishedActionPrompt.html.twig', [
            'entity' => 'Exercise-error',
            'action' => 'Created',
            'success' => true,
        ]);
    }

    ////Route: exercise/{id}
    #[Route('/exercise/delete/{id}', name:'exercise_delete', requirements: ['id' => '^\d+$'], methods: ['DELETE'])]
    public function delete(int $id, ExerciseRepository $exerciseRepository): Response
    {
        $exercise = $exerciseRepository->findOneById($id);
        $exerciseRepository->deleteOneById($id);
        return $this->redirectToRoute('exercises_index');
//        return $this->render('finishedActionPrompt.html.twig', [
//            'entity' => 'Exercise',
//            'action' => 'deleted',
//            'success' => true,
//        ]);
    }

//    #[Route('/exercise/deleteView/{id}', name:'exercise_delete_view', requirements: ['id' => '^\d+$'], methods: ['GET'])]
//    public function deleteView(int $id, ExerciseRepository $exerciseRepository): Response
//    {
//        $exercise = $exerciseRepository->findOneById($id);
//        $form = $this->createForm(DeleteButtonType::class, new stdClass(), [
//            'action' => $this->generateUrl('exercise_delete', ['id' => $id]),
//            'method' => 'DELETE',
//        ]);
//
//        return $this->render('exercise/deleteView.html.twig',[
//            'exercise' => $exercise,
//            'form' => $form,
//        ]);
//    }
}
