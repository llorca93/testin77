<?php

namespace App\Form;

use App\Entity\Communes;
use App\Entity\ClientsCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CommunesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('departement', IntegerType::class, [
                'label' => 'N° du département'
            ])
            ->add('category', EntityType::class, [
                'class' => ClientsCategory::class,
                'choice_label' => 'name'
                
            ])
            ->add('valider', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-block btn-success mt-5'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Communes::class,
        ]);
    }
}
