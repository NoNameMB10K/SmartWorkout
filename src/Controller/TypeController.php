<?php

namespace App\Controller;

use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TypeController extends AbstractController
{
    #[Route('/types', name: 'app_type', methods: ['GET'])]
    public function show(TypeRepository $typeRepository): Response
    {
        return $this->render('type/show.html.twig', [
            'types' => $typeRepository->findAll(),
        ]);
    }
}
