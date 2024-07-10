<?php

namespace App\Controller;


use App\Entity\Workout;
use App\Form\Type\DeleteButtonType;
use App\Form\Type\WorkoutType;
use App\Repository\ExerciseLogRepository;
use App\Repository\UserRepository;
use App\Repository\WorkoutRepository;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WorkoutController extends AbstractController
{
    #[Route('/workouts', name: 'workouts_index', methods: ['GET'])]
    public function index(WorkoutRepository $workoutRepository, UserRepository $userRepository, RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();
        $mail = $session->get("_security.last_username");
        $user = $userRepository->findOneByMail($mail);

        return $this->render('workout/index.html.twig', ['workouts' => $workoutRepository->findAllByUserId($user)]);
    }

    #[Route('/workouts/new', name: 'new_workout', methods: ['GET'])]
    public function new(): Response
    {
        $workout = new Workout();

        $form = $this->createForm(WorkoutType::class, $workout, [
            'action' => $this->generateUrl('create_workout'),
            'method' => 'POST',
        ]);

        return $this->render('workout/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/workouts', name:'create_workout', methods: ['POST'])]
    public function create(Request $request, WorkoutRepository $workoutRepository, UserRepository $userRepository, RequestStack $requestStack): Response
    {
        $workout = new Workout();
        $form = $this->createForm(WorkoutType::class, $workout);

        $session = $requestStack->getSession();
        $mail = $session->get("_security.last_username");
        $user = $userRepository->findOneByMail($mail);
        $workout->setUser($user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $workoutRepository->saveOne($workout);
            return $this->redirectToRoute('workouts_index');
        }

        return $this->render('finishedActionPrompt.html.twig', [
            'entity' => 'Error-workout',
            'action' => 'Created',
            'success' => true,
        ]);
    }

    #[Route('/workout/{id}', name:'show_workouts', requirements: ['id' => '^\d+$'], methods: ['GET'])]
    public function show(int $id, WorkoutRepository $workoutRepository): Response
    {
        $workout = $workoutRepository->findOneById($id);
        return $this->render('workout/show.html.twig', [
            'workout' => $workout,
        ]);
    }

    #[Route('/workout/edit/{id}', name:'edit_workout', requirements: ['id' => '^\d+$'], methods: ['GET'])]
    public function edit(int $id, WorkoutRepository $workoutRepository): Response
    {
        $workout = $workoutRepository->findOneById($id);
        $workoutForm = $this->createForm(WorkoutType::class, $workout, [
            'action' => $this->generateUrl('update_workout', ['id' => $id]),
            'method' => 'PATCH',
        ]);

        $deleteWorkout = $this->createForm(DeleteButtonType::class, new stdClass(), [
            'action' => $this->generateUrl('delete_workout', ['id' => $id]),
            'method' => 'DELETE',
        ]);

        return $this->render('workout/edit.html.twig', [
            'workoutForm' => $workoutForm,
            'deleteWorkout' => $deleteWorkout,
        ]);
    }

    #[Route('/workout/{id}', name:'update_workout', requirements: ['id' => '^\d+$'], methods: ['PATCH'])]
    public function update(int $id, WorkoutRepository $workoutRepository, Request $request): Response
    {
        $workout = $workoutRepository->findOneById($id);
        $workoutForm = $this->createForm(WorkoutType::class, $workout, [
            'action' => $this->generateUrl('update_workout', ['id' => $id]),
            'method' => 'PATCH',
        ]);

        $workoutForm->handleRequest($request);
        if ($workoutForm->isSubmitted() && $workoutForm->isValid()) {
            $workoutRepository->saveOne($workout);
            return $this->redirectToRoute('workouts_index');
        }

        return $this->render('finishedActionPrompt.html.twig', [
            'entity' => 'Error-workout',
            'action' => 'Created',
            'success' => true,
        ]);
    }

    #[Route('/workout/{id}', name:'delete_workout', requirements: ['id' => '^\d+$'], methods: ['DELETE'])]
    public function delete(int $id, WorkoutRepository $workoutRepository, ExerciseLogRepository $exerciseLogRepository): Response
    {
        $workout = $workoutRepository->findOneById($id);
        $exerciseLogRepository->deleteWorkoutEntries($workout);
        $workoutRepository->deleteOneById($id);
        return $this->redirectToRoute('workouts_index');
    }
}