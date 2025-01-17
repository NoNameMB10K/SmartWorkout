<?php

namespace App\Form\Type;

use stdClass;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeleteButtonType extends AbstractType
{    public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('delete', SubmitType::class)
    ;
}


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => stdClass::class,
        ]);
    }
}