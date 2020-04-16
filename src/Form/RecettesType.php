<?php

namespace App\Form;

use App\Entity\Recettes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class RecettesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class)
            ->add('image', FileType::class, [
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/gif',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Picture',
                    ])
                ],
            ])
            ->add('top_recette', CheckboxType::class, ['label' => false, 'required' => false])
//            ->add('note_moyenne')
//            ->add('date_add')
//            ->add('date_update')
//            ->add('date_delete')
//            ->add('activate')
            ->add('descriptions', TextareaType::class)
            ->add('tmp_prepa', TextType::class)
            ->add('tmp_cuisson', TextType::class)
 //          ->add('users')
            ->add('categories', EntityType::class, [
                'class' => 'App:Categories',
                'multiple' => false, // a user can select only one option per submission
                'expanded' => false // options will be presented in a <select> element; set this to true, to present the data as checkboxes
            ])
            ->add('save', SubmitType::class, ['label' => false, 'translation_domain' => false])
            ->add('preparations', CollectionType::class, [
                'entry_type' => PreparationsType::class
            ])
            ->add('ingredients', CollectionType::class, [
                'entry_type' => IngredientsType::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recettes::class,
        ]);
    }
}
