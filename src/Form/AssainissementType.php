<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Assainissement;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AssainissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                
            ])
            ->add('description', TextareaType::class, [
                'label' => 'description',
                'required' => false,
                'attr' => [
                    'class' => 'tiny'
                ]
               
                
            ])
            ->add('file', FileType::class, [
                'required' => false,
                'label' => 'Fichier',
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
                        'mimeTypesMessage' => 'Merci de sélectionner un pdf valide',
                    ])
                ]
                
            ])
            ->add('filename', TextType::class, [
                'label' => 'Nom du fichier',
                'required' => false
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie',
                'class' => Category::class,
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
            'data_class' => Assainissement::class,
        ]);
    }
}
