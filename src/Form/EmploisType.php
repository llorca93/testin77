<?php

namespace App\Form;

use App\Entity\Emplois;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EmploisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('description', CKEditorType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'p-3 mb-3 mt-3'
                ]
            ])
            ->add('file', FileType::class, [
                'label' => 'Fichier',
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'format accepté: pdf 1Mo maximum'
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf'
                        ],
                        'mimeTypesMessage' => 'Merci de sélectionner un pdf valide'
                    ])
                ]
            ])
            ->add('filename', TextType::class, [
                'label' => 'Nom du fichier',
                'required' => false
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
            'data_class' => Emplois::class,
        ]);
    }
}
