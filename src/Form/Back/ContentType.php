<?php

namespace App\Form\Back;

use App\Entity\Recipe;
use App\Entity\Content;
use App\Entity\Measure;
use App\Entity\Ingredient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity')
            ->add('recipe', EntityType::class, [
                'class' => Recipe::class,
                'choice_label' => 'title',
                'multiple' => false
            ])
            ->add('ingredient', EntityType::class, [
                'class' => Ingredient::class,
                'choice_label' => 'name',
                'multiple' => false
            ])
            ->add('measure', EntityType::class, [
                'class' => Measure::class,
                'choice_label' => 'type',
                'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Content::class,
        ]);
    }
}
