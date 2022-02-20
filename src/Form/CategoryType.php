<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',null,[
                'label' => 'Nazwa *'
            ])
            ->add('parent',null,[
                'label' => 'Kategoria nadrzędna'
            ])
            ->add('final',null,[
                'label' => 'Ostateczna *'
            ])
            ->add('childs',TextType::class,[
                'label' => 'Dodaj ćwiczenia',
                'help'  => 'Tylko dla kategorii ostatecznych',
                'mapped' => false
            ])
            //->add('excercises',EntityType::class,[
            //    'class' => Excercise::class,
            //    'choice_label' => 'name',
            //    'multiple' => true
            //])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
