<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\UserGroup;
use App\Form\Type\SuggestagsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('Users',SuggestagsType::class,[
                'class_transformer' => User::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserGroup::class,
        ]);
    }
}
