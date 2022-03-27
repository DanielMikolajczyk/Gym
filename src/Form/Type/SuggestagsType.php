<?php

namespace App\Form\Type;

use App\Entity\Category;
use App\Entity\User;
use App\Form\DataTransformer\StringToArrayTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SuggestagsType extends AbstractType
{
    public function __construct(
        private EntityManagerInterface $em
    ) {
    }

    //Transform data from string to array and vice versa.
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->addModelTransformer(new StringToArrayTransformer($this->em,$options))
        ;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        //Find all given entities of searched class and turn them into comma separated string of ids.
        if($view->vars['data']){
            $searchIds = explode(',',$view->vars['data']);
            $entities = $this->em->getRepository($options['class_transformer'])->findBy(['id' => $searchIds]);
            $dataNames = '';
            foreach($entities as $key => $entity){
                if($entity instanceof User){
                    $dataNames .= $entity->getFullName();
                }else{
                    $dataNames .= $entity->getName();
                }
                if ($key != array_key_last($entities)) {
                    $dataNames .= ',';
                }
            }
            $view->vars['data_names'] = $dataNames;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(): ?string
    {
        return TextType::class;
    }
/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class_transformer' => Category::class
        ]);
    }
}
