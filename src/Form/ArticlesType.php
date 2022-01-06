<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\ArticlesCategory;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ArticlesType extends AbstractType
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
            ->add('illustration', FileType::class, [
                'label' => 'Image jpg/jpeg/png',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                            'image/jp2'
                        ],
                        'mimeTypesMessage' => 'Merci de sélectionner une image au format PNG, JPG, JPEG ou JP2'
                    ])
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => ArticlesCategory::class,
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
            'data_class' => Articles::class,
        ]);
    }
}
