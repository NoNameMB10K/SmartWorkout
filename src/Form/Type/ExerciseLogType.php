<?php

namespace App\Form\Type;

use App\Entity\Exercise;
use App\Entity\ExerciseLog;
use App\Repository\ExerciseRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Positive;

class ExerciseLogType extends AbstractType
{
    private ExerciseRepository $exerciseRepository;
    public function __construct(ExerciseRepository $exerciseRepository)
    {
        $this->exerciseRepository = $exerciseRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
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
            ->add('duration', TimeType::class)
            ->add('exercise', EntityType::class, [
                'class' => Exercise::class,
                'choices' => $this->exerciseRepository->findAll(),
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