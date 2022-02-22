<?php

namespace App\Controller;

use App\Repository\ExcerciseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/exercise')]
class ExcerciseUtilityController extends AbstractController
{
    #[Route('/suggest', methods: ['GET'])]
    public function getExcercisesSuggestions(Request $request, ExcerciseRepository $excerciseRepository)
    {
        //Return if no parameters provided
        if(!$request->query->get('term')){
            return $this->json(['suggestions' => '']);
        }

        $excercises = $excerciseRepository->findAllWhereNameLike($request->query->get('term'));

        //Return if no parameters found
        if(!$excercises){
            return $this->json(['suggestions' => '']);    
        }

        $excerciseNames = [];
        foreach($excercises as $excercise){
            $excerciseNames[] = array(
                "tag"       => $excercise->getName(),
                "value"     => $excercise->getId(),
                "background"=> 'green',
                "color"     => 'white'
            );
        }
        return $this->json([
            'suggestions' => $excerciseNames
        ]);
    }
}
