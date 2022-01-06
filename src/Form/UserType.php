<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'required' => true,
                'attr' => [
                    'placeholder' => 'John',
                    'class' => 'form-control form-control-md g-brd-gray-light-v7 g-brd-gray-light-v3--focus rounded-0 g-px-14 g-py-10'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Doe',
                    'class' => 'form-control form-control-md g-brd-gray-light-v7 g-brd-gray-light-v3--focus rounded-0 g-px-14 g-py-10'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true,
                'attr' => [
                    'placeholder' => 'prenom.nom@domaine.com',
                    'class' => 'form-control form-control-md g-brd-gray-light-v7 g-brd-gray-light-v3--focus rounded-0 g-px-14 g-py-10'
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => 'Téléphone',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Numéro de téléphone',
                    'class' => 'form-control form-control-md g-brd-gray-light-v7 g-brd-gray-light-v3--focus rounded-0 g-px-14 g-py-10'
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'required' => false,
                'multiple' => true,
                'expanded' => true,

                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
                    'Utilisateur' => 'ROLE_USER'
                ],
               'attr' => [
                   'class' => 'checkpl'
               ] 
               
            ])
            ->add('valider', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-md u-btn-primary g-mr-10 g-mb-15'
                ]
            ])
            
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
