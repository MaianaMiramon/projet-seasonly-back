<?php

namespace App\Form\Back;

use App\Entity\Meal;
use App\Entity\Recipe;
use DateTimeImmutable;
use App\Entity\Content;
use App\Entity\Measure;
use App\Entity\Ingredient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Nom de la recette'
            ])  
            ->add('description', TextType::class, [
                'label' => 'Description de la recette'
            ])
            ->add('image', TextType::class, [
                'label' => 'Image de la recette (URL)'
            ])
            ->add('instruction', TextType::class, [
                'label' => 'Etapes de préparation de la recette'
            ])
            ->add('duration', TextType::class, [
                'label' => 'Temps pour faire la recette'
            ])
            ->add('serving', IntegerType::class, [
                'label' => 'Nombre de personnes'
            ])
            ->add('created_at')
            ->add('updated_at', null, [
                'label' => 'Dernière modification'
            ])
            ->add('meal', EntityType::class, [
                'class' => Meal::class,
                'choice_label' => 'name',
                'multiple' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
