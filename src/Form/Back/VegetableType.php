<?php

namespace App\Form\Back;

use App\Entity\Genre;
use App\Entity\Month;
use App\Entity\Botanical;
use App\Entity\Vegetable;
use App\Entity\Ingredient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class VegetableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Nom du vegetable'
            ])  
            ->add('description', TextType::class, [
                'label' => 'Description du vegetable'
            ])
            ->add('image', TextType::class, [
                'label' => 'Image du vegetable'
            ])
            ->add('benefits', TextType::class, [
                'label' => 'Bénéfices liés au vegetable'
            ])
            ->add('local', ChoiceType::class, [
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'multiple' => false,
                'expanded' => true
            ])
            ->add('conservation', TextType::class, [
                'label' => 'Conservation du vegetable'
            ])
            ->add('created_at')
            ->add('updated_at')
            ->add('months', EntityType::class, [
                'class' => Month::class,
                'choice_label' => 'name',
                'multiple' => true
            ])
            ->add('botanical', EntityType::class, [
                'class' => Botanical::class,
                'choice_label' => 'name'
            ])
            ->add('genre', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'name',
                'multiple' => false
            ])
            ->add('ingredient', EntityType::class, [
                'class' => Ingredient::class,
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vegetable::class,
        ]);
    }
}
