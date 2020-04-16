<?php

namespace App\Form;

use App\Entity\Preparations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PreparationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('etapes', TextareaType::class, ['label' => false])
            ->add('ordres', NumberType::class, ['label' => false])
//            ->add('date_add')
//            ->add('date_update')
//            ->add('date_delete')
//            ->add('activate')
//            ->add('recettes')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Preparations::class,
        ]);
    }
}
