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
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Ex: Pizza 4 fromages',
            ])  
            ->add('description', TextType::class, [
                'label' => 'C\'est une pizza..'
            ])
            ->add('image', TextType::class, [
                'label' => 'https://exemple.com'
            ])
            ->add('instruction', TextType::class, [
                'label' => 'Etape 1 : ..'
            ])
            ->add('duration', TextType::class, [
                'label' => 'Ex: 120'
            ])
            ->add('serving', IntegerType::class, [
                'label' => 'Ex: 4'
            ])
            ->add('created_at', DateTimeType::class, array(
                'input' => 'datetime_immutable'
            ))
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
