<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('parent',EntityType::class,[
                'class' => Category::class,
                'label' => 'Kategoria nadrzędna',
            ])
            ->add('final',null,[
                'label' => 'Ostateczna *'
            ])
            ->add('excercises',TextType::class,[
                'label' => 'Dodaj ćwiczenia',
                'help'  => 'Tylko dla kategorii ostatecznych',
                'mapped' => false,
                'required' => false
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
