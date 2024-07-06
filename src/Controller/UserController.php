<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\DeleteButtonType;
use App\Form\Type\UserType;
use App\Form\Type\UserUpdateType;
use App\Repository\UserRepository;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/users/new', name:'users_new', methods: ['GET'])]
    public function new(): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, [
            'action' => $this->generateUrl('users_create'),
            'method' => 'POST',
        ]);

        return $this->render('user/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/users', name:'users_create', methods: ['POST'])]
    public function create(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->saveOne($user);
            return $this->render('finishedActionPrompt.html.twig', [
                'entity' => 'User',
                'action' => 'created',
                'success' => true,
            ]);
        }

        ////////////////////////////////////////////////
        return $this->render('finishedActionPrompt.html.twig', [
            'entity' => 'Error',
            'action' => 'Created',
            'success' => true,
        ]);
    }

    #[Route('/user/{id}', name:'user_show', requirements: ['id' => '^\d+$'], methods: ['GET'])]
    public function show(int $id, UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneById($id);
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/user/edit/{id}', name:'user_edit', requirements: ['id' => '^\d+$'], methods: ['GET'])]
    public function edit(int $id, UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneById($id);
        $userForm = $this->createForm(UserUpdateType::class, $user, [
            'action' => $this->generateUrl('user_update', ['id' => $id]),
            'method' => 'PATCH',
        ]);

        $deleteUser = $this->createForm(DeleteButtonType::class, new stdClass(), [
            'action' => $this->generateUrl('user_delete', ['id' => $id]),
            'method' => 'DELETE',
        ]);

        return $this->render('user/edit.html.twig', [
            'userForm' => $userForm,
            'deleteUser' => $deleteUser,
        ]);
    }

    #[Route('/user/{id}', name:'user_update', requirements: ['id' => '^\d+$'], methods: ['PATCH'])]
    public function update(int $id, UserRepository $userRepository, Request $request): Response
    {
        $user = $userRepository->findOneById($id);
        $form = $this->createForm(UserUpdateType::class, $user, [
            'action' => $this->generateUrl('user_update', ['id' => $id]),
            'method' => 'PATCH',
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->saveOne($user);
            return $this->render('finishedActionPrompt.html.twig', [
                'entity' => 'User',
                'action' => 'updated',
                'success' => true,
            ]);
        }

        ////////////////////////////////////////////////
        return $this->render('finishedActionPrompt.html.twig', [
            'entity' => 'Error',
            'action' => 'Created',
            'success' => true,
        ]);

    }

    ////Route: user/{id}
    #[Route('/user/delete/{id}', name:'user_delete', requirements: ['id' => '^\d+$'], methods: ['DELETE'])]
    public function delete(int $id, UserRepository $userRepository): Response
    {
        //$user = $userRepository->findOneById($id);
        $userRepository->deleteOneById($id);
        return $this->render('finishedActionPrompt.html.twig', [
            'entity' => 'User',
            'action' => 'deleted',
            'success' => true,
        ]);
    }

    #[Route('/user/deleteView/{id}', name:'user_delete_view', requirements: ['id' => '^\d+$'], methods: ['GET'])]
    public function deleteView(int $id, UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneById($id);
        $form = $this->createForm(DeleteButtonType::class, new stdClass(), [
            'action' => $this->generateUrl('user_delete', ['id' => $id]),
            'method' => 'DELETE',
        ]);

        return $this->render('user/deleteView.html.twig',[
            'user' => $user,
            'form' => $form,
        ]);
    }


}
