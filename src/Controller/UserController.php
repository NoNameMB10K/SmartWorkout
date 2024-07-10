<?php

namespace App\Controller;

use App\Form\Type\DeleteButtonType;
use App\Form\Type\UserUpdateType;
use App\Repository\ExerciseLogRepository;
use App\Repository\ExerciseRepository;
use App\Repository\TypeRepository;
use App\Repository\UserRepository;
use App\Repository\WorkoutRepository;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/users', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/user', name:'user_show', methods: ['GET'])]
    public function show(UserRepository $userRepository, RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();
        $mail = $session->get("_security.last_username");
        $user = $userRepository->findOneByMail($mail);

        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/user/edit', name:'user_edit', methods: ['GET'])]
    public function edit(UserRepository $userRepository, RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();
        $mail = $session->get("_security.last_username");
        $user = $userRepository->findOneByMail($mail);

        $userForm = $this->createForm(UserUpdateType::class, $user, [
            'action' => $this->generateUrl('user_update'),
            'method' => 'PATCH',
        ]);

        $deleteUser = $this->createForm(DeleteButtonType::class, new stdClass(), [
            'action' => $this->generateUrl('user_delete'),
            'method' => 'DELETE',
        ]);

        return $this->render('user/edit.html.twig', [
            'userForm' => $userForm,
            'deleteUser' => $deleteUser,
        ]);
    }

    #[Route('/user', name:'user_update', methods: ['PATCH'])]
    public function update(UserRepository $userRepository, Request $request , RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();
        $mail = $session->get("_security.last_username");
        $user = $userRepository->findOneByMail($mail);

        $form = $this->createForm(UserUpdateType::class, $user, [
            'action' => $this->generateUrl('user_update'),
            'method' => 'PATCH',
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->saveOne($user);
            return $this->redirectToRoute('user_show');
        }

        return $this->render('finishedActionPrompt.html.twig', [
            'entity' => 'Error',
            'action' => 'Created',
            'success' => true,
        ]);

    }
    #[Route('/user', name:'user_delete', methods: ['DELETE'])]
    public function delete(UserRepository $userRepository, RequestStack $requestStack,
    ExerciseRepository $exerciseRepository, WorkoutRepository $workoutRepository,
    TypeRepository $typeRepository, ExerciseLogRepository $exerciseLogRepository): Response
    {
        $session = $requestStack->getSession();
        $mail = $session->get("_security.last_username");
        $user = $userRepository->findOneByMail($mail);

        $exercises =  $exerciseRepository->findAllByUserId($user);
        $workouts =  $workoutRepository->findAllByUserId($user);
        $types =  $typeRepository->findAllByUserId($user);

        foreach ($workouts as $workout) {
            $exerciseLogs = $exerciseLogRepository->findByWorkoutId($workout->getId());
            foreach ($exerciseLogs as $exerciseLog) {
                $exerciseLogRepository->deleteOneById($exerciseLog->getId());
            }
        }
        foreach ($exercises as $exercise) {
            $exerciseRepository->deleteOneById($exercise->getId());
        }
        foreach ($workouts as $workout) {
            $workoutRepository->deleteOneById($workout->getId());
        }
        foreach ($types as $type) {
            $typeRepository->deleteOneById($type->getId());
        }

        $userRepository->deleteOneById($user->getId());

        return $this->render('finishedActionPrompt.html.twig', [
            'entity' => 'User',
            'action' => 'deleted',
            'success' => true,
        ]);
    }
}
