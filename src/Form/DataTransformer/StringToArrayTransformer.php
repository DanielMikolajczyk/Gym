<?php

namespace App\Form\DataTransformer;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class StringToArrayTransformer implements DataTransformerInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private array $options
    ) {
    }

    // Transform array to comma separated string
    public function transform($value): ?string
    {
        if($value == null || $value->isEmpty()){
            return null;
        }
        
        return implode(',',$value->map(function($entity){
            return $entity->getId();
        })->toArray());
    }

    // Transform comma separated string of ids to array
    public function reverseTransform($string): array
    {
        if($string === '' || $string === null){
            throw new TransformationFailedException(sprintf(
                'Ćwiczenie musi należeć do przynajmniej jednej kategorii.'
            ));
        }

        foreach(explode(',',$string) as $id){
            if(!$category = $this->em->getRepository($this->options['class_transformer'])->find($id)){
                throw new TransformationFailedException(sprintf(
                    'Podano niepoprawne id kategorii.'
                ));
            }
            $categories[] = $category;
        }
        return $categories;
    }
}
