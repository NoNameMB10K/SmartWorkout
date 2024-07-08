<?php

namespace App\Controller;

use App\Entity\Type;
use App\Form\Type\DeleteButtonType;
use App\Form\Type\TypeType;
use App\Repository\TypeRepository;
use App\Repository\UserRepository;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TypeController extends AbstractController
{
    #[Route('/types', name: 'types_index', methods: ['GET'])]
    public function show(TypeRepository $typeRepository, UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneByName('Alex Simion');

        return $this->render('type/index.html.twig', [
            'types' => $typeRepository->findAllByUserId($user),
        ]);
    }
    #[Route('/types/new',name:'types_new', methods: ['GET'])]
    public function new(): Response
    {
        $type = new Type();
        $form = $this->createForm(TypeType::class, $type, [
            'action' => $this->generateUrl('types_create'),
            'method' => 'POST'
        ]);

        return $this->render('type/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/types',name:'types_create', methods: ['POST'])]
    public function create(Request $request, TypeRepository $typeRepository, UserRepository $userRepository): Response
    {
        $type = new Type();
        $form = $this->createForm(TypeType::class, $type, [
            'action' => $this->generateUrl('types_create'),
            'method' => 'POST'
        ]);

        $user = $userRepository->findOneByName('Alex Simion');
        $type->setUser($user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $typeRepository->saveOne($type);
            return $this->redirectToRoute('types_index');
        }

        ////////////////////////////////////////////////
        return $this->render('finishedActionPrompt.html.twig', [
            'entity' => 'Type-error',
            'action' => 'created',
            'success' => true,
        ]);
    }

    #[Route('/type/edit/{id}', name:'type_edit', requirements: ['id' => '^\d+$'], methods: ['GET'])]
    public function edit(int $id, TypeRepository $typeRepository): Response
    {
        $type = $typeRepository->findOneById($id);
        $editForm = $this->createForm(TypeType::class, $type, [
            'action' => $this->generateUrl('type_update', ['id' => $id]),
            'method' => 'PATCH',
        ]);

        $deleteForm = $this->createForm(DeleteButtonType::class, new stdClass(), [
            'action' => $this->generateUrl('type_delete', ['id' => $id]),
            'method' => 'DELETE',
        ]);

        return $this->render('type/edit.html.twig', [
            'editForm' => $editForm,
            'deleteFrom' => $deleteForm,
        ]);
    }

    #[Route('/type/{id}', name:'type_update', requirements: ['id' => '^\d+$'], methods: ['PATCH'])]
    public function update(int $id,Request $request, TypeRepository $typeRepository): Response
    {
        $type = $typeRepository->findOneById($id);
        $editForm = $this->createForm(TypeType::class, $type, [
            'action' => $this->generateUrl('type_update', ['id' => $id]),
            'method' => 'PATCH',
        ]);

        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $typeRepository->saveOne($type);
            return $this->redirectToRoute('types_index');
        }

        ////////////////////////////////////////////////
        return $this->render('finishedActionPrompt.html.twig', [
            'entity' => 'Exercise-error',
            'action' => 'Created',
            'success' => true,
        ]);
    }

    #[Route('/type/delete/{id}', name:'type_delete', requirements: ['id' => '^\d+$'], methods: ['DELETE'])]
    public function delete(int $id, TypeRepository $typeRepository): Response
    {
        $type = $typeRepository->findOneById($id);
        $typeRepository->deleteOneById($id);
        return $this->redirectToRoute('types_index');
    }


}
