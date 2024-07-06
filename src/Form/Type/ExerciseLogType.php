<?php

namespace App\Form\Type;

use App\Entity\Exercise;
use App\Entity\ExerciseLog;
use App\Repository\ExerciseLogRepository;
use App\Repository\ExerciseRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('nrReps', NumberType::class)
            ->add('duration', TimeType::class)
            ->add('exercise', EntityType::class, [
                'class' => Exercise::class,
                'choices' => $this->exerciseRepository->findAll(),
                'choice_label' => 'name', // Property of Type entity to display in dropdown
                'placeholder' => 'Select a exercise',
                'required' => true,
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ExerciseLog::class,
        ]);
    }
}