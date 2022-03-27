<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Excercise;
use App\Form\Type\SuggestagsType;
use App\Validator\CategoriesExistance;
use App\Validator\CategoriesExistanceValidator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name')
                ->add('parent',SuggestagsType::class,[
                    'class_transformer' => Category::class
                ])
                ->add('main')
                ->add('final')
                ->add('excercises', SuggestagsType::class,[
                    'class_transformer' => Excercise::class
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
