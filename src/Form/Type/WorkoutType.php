<?php

namespace App\Form\Type;

use App\Entity\Type;
use App\Entity\Workout;
use App\Repository\TypeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkoutType extends AbstractType
{
    private TypeRepository $typeRepository;
    public function __construct(TypeRepository $typeRepository)
    {
        $this->typeRepository = $typeRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'pattern' => '^[a-zA-Z]+$',
                    'message' => 'Name can contain only letters',
                ]])
            ->add('date', DateTimeType::class)
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choices' => $this->typeRepository->findAll(),
                'choice_label' => 'name', // Property of Type entity to display in dropdown
                'placeholder' => 'Select a type',
                'required' => true,
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Workout::class,
        ]);
    }
}