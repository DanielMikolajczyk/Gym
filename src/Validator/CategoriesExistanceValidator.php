<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\Repository\CategoryRepository;

class CategoriesExistanceValidator extends ConstraintValidator
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;    
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\CategoriesExistance */

        if (null === $value || '' === $value) {
            return;
        }
        
        if(!strpos($value,',')){
            if(!$this->categoryRepository->find($value)){
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
            }
            return ;
        }

        $categories = explode(',',$value);
        foreach($categories as $id){
            if(!$this->categoryRepository->find($id)){  
                $this->context->buildViolation($constraint->message)
                    ->addViolation();
            }
        }

        return ;
    }
}
