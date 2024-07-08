<?php

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'pattern' => '^[a-zA-Z ]+$',
                    'placeholder' => 'Can contain only letters or space',
                ]])
            ->add('password', PasswordType::class)
            ->add('birthday',BirthdayType::class, array('required' => false) )
            ->add('gender', ChoiceType::class,
                ['choices' =>
                    [
                        'Other' => Null,
                        'Male' => 1,
                        'Female' => 2,
                    ],])
            ->add('isTrainer', ChoiceType::class, [
                'choices' =>
                    [
                        'No' => false,
                        'Yes' => true,
                    ]
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}