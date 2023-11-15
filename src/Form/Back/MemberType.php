<?php

namespace App\Form\Back;

use App\Entity\User;
use App\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class, [
                'label' => 'Nom d\'utilisateur'
            ])  
            ->add('roles', ChoiceType::class, [
                'label' => 'Rôles',
                'choices' => [
                    'ROLE_USER' => 'ROLE_USER',
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                ],
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('email', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                'multiple' => false,
            ])
            ->add('newsletter', EntityType::class, [
                'class' => User::class,
                'label' => 'Inscription à la newsletter',
                'choice_label' => 'newsletter',
                'multiple' => false,
                'expanded' => true,
                'mapped' => false,
            ])
            ->add('created_at')
            ->add('updated_at')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}