<?php

namespace App\Form\Type;

use App\Entity\Exercise;
use App\Entity\ExerciseLog;
use App\Repository\ExerciseRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ExerciseLogType extends AbstractType
{
    private ExerciseRepository $exerciseRepository;
    private RequestStack $requestStack;
    private UserRepository $userRepository;
    public function __construct(ExerciseRepository $exerciseRepository, RequestStack $requestStack, UserRepository $userRepository)
    {
        $this->exerciseRepository = $exerciseRepository;
        $this->requestStack = $requestStack;
        $this->userRepository = $userRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $session = $this->requestStack->getSession();
        $mail = $session->get("_security.last_username");
        $user = $this->userRepository->findOneByMail($mail);

        $builder
            ->add('nrReps', IntegerType::class, [
                'attr' => [
                    'min' => 1,
                ]
            ])
            ->add('weight', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                ]
            ])
            ->add('duration', TimeType::class, [
                'widget' => 'single_text',
                'input' => 'datetime',
                'with_seconds' => true,
                'html5' => true,
                'attr' => [
                    'step' => 1,
                ],
            ])
            ->add('exercise', EntityType::class, [
                'class' => Exercise::class,
                'choices' => $this->exerciseRepository->findAllByUserId($user),
                'choice_label' => 'name',
                'placeholder' => 'Select a exercise',
                'required' => true,
            ])
            ->add('Save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ExerciseLog::class,
        ]);
    }
}