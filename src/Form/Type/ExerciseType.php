<?php

namespace App\Form\Type;

use App\Entity\Exercise;
use App\Entity\Type;
use App\Repository\TypeRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ExerciseType extends AbstractType
{
    private TypeRepository $typeRepository;
    private RequestStack $requestStack;
    private UserRepository $userRepository;
    public function __construct(TypeRepository $typeRepository, RequestStack $requestStack, UserRepository $userRepository)
    {
        $this->typeRepository = $typeRepository;
        $this->requestStack = $requestStack;
        $this->userRepository = $userRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $session = $this->requestStack->getSession();
        $mail = $session->get("_security.last_username");
        $user = $this->userRepository->findOneByMail($mail);

        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'pattern' => '^[a-zA-Z ]+$',
                    'placeholder' => 'Can contain only letters or space',
                ]])
            ->add('linkToVideo', TextType::class, ['required' => false])
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choices' => $this->typeRepository->findAllByUserId($user),
                'choice_label' => 'name', // Property of Type entity to display in dropdown
                'placeholder' => 'Select a type',
                'required' => false,
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exercise::class,
        ]);
    }
}