<?php

namespace App\Form;

use App\Entity\Moto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',TextType::Class,array('required'=>true,'label'=>false))
            ->add('description',TextType::Class,array('required'=>true,'label'=>false))
            ->add('km',IntegerType::Class,array('required'=>true,'label'=>false))
            ->add('prix',IntegerType::Class,array('required'=>true,'label'=>false))
            ->add('date',DateType::Class,array('required'=>true,'label'=>false))
            ->add('puissance',IntegerType::Class,array('required'=>true,'label'=>false))
            // ->add('Marque',TextType::Class,array('required'=>true,'label'=>false))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Moto::class,
        ]);
    }
}
