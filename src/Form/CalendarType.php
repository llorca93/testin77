<?php

namespace App\Form;

use App\Entity\Calendar;
use App\Entity\CommunesRdv;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CalendarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('start', DateTimeType::class, [
                'label' => 'début',
                'date_widget' => 'single_text'
            ])
            ->add('end', DateTimeType::class, [
                'label' => 'Fin',
                'date_widget' => 'single_text'
            ])
            ->add('communesRdv', EntityType::class, [
                'label' => 'Commune',
                'class' => CommunesRdv::class,
                'choice_label' => 'name'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description'
            ])
            ->add('all_day')
            ->add('background_color', ColorType::class, [
                'label' => 'Couleur'
            ])
            ->add('border_color', ColorType::class, [
                'label' => 'Bordure'
            ])
            ->add('text_color', ColorType::class, [
                'label' => 'Couleur du texte'
            ])
            ->add('valider', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-block btn-success mt-5'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Calendar::class,
        ]);
    }
}
