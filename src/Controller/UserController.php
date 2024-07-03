<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserType;
use App\Form\Type\UserUpdateType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user', methods: ['GET','POST'])]
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //$userRepository->saveOne($user);
            return $this->render('finishedActionPrompt.html.twig', [
                'entity' => 'User',
                'action' => 'created',
                'success' => true,
            ]);
        }

        return $this->render('user/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/user/{id}', requirements: ['id' => '^\d+$'], methods: ['GET', 'PATCH'])]
    public function edit(int $id, Request $request, UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneById($id);
        $form = $this->createForm(UserUpdateType::class, $user, [
            'action' => $this->generateUrl('app_user_edit', ['id' => $id]),
            'method' => 'PATCH',
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //$userRepository->saveOne($user);
            return $this->render('finishedActionPrompt.html.twig', [
                'entity' => 'User',
                'action' => 'updated',
                'success' => true,
            ]);
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form,
        ]);
    }

}
