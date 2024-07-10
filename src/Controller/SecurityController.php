<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\RegistrationFormType;
use App\Form\Type\ResetPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            if($form->get('areYouACoach')->getData())
            {
                $user->setRoles(['ROLE_COACH']);
            }
            else
            {
                $user->setRoles(['ROLE_USER']);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    #[Route(path: '/reset_password', name: 'reset_password', methods: ['GET','POST'])]
    public function reset_password(UserPasswordHasherInterface $userPasswordHasher, Request $request, RequestStack $requestStack, UserRepository $userRepository): Response
    {
        $user_new = new User();

        $session = $requestStack->getSession();
        $mail = $session->get("_security.last_username");
        $user = $userRepository->findOneByMail($mail);

        $form = $this->createForm(ResetPasswordType::class, $user_new);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user_new->setPassword(
                $userPasswordHasher->hashPassword(
                    $user_new,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setPassword($user_new->getPassword());
            $userRepository->saveOne($user);

            return $this->redirectToRoute('app_home');
        }

        return $this->render('security/resetPassword.html.twig', [
            'resetForm' => $form,
        ]);
    }
}
