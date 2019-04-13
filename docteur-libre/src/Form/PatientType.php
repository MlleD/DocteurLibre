<?php

namespace App\Form;

use App\Entity\Patient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, [
                'attr' => [
                    'placeholder' => "Votre adresse mail",
                    'class' => "bootstrap_classes"
                ]
            ])
            ->add('date_of_birth')
            ->add('first_name', TextType::class, [
                'attr' => [
                    'placeholder' => "Votre prénom",
                    'class' => "bootstrap_classes"
                ]
            ])
            ->add('last_name', TextType::class, [
                'attr' => [
                    'placeholder' => "Votre nom",
                    'class' => "bootstrap_classes"
                ]
            ])
            ->add('sex')
            ->add('phone_number', TextType::class, [
                'attr' => [
                    'placeholder' => "Votre numéro de téléphone",
                    'class' => "bootstrap_classes"
                ]
            ])
            ->add('password')
            ->add('register', SubmitType::class, [
                'attr' => [
                    'class' => "bootstrap_classes"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
