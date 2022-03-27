<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ExcerciseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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

    #[Route('/category/{category}', methods: ['GET'])]
    public function getExcerciseByCategory(Request $request, Category $category)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers,$encoders);

        if(!$category->getFinal()){
            //TODO
            //Handle non final categories
        }

        $categoryName = $category->getName();
        $excercises = $category->getExcercises();
        

        $json = $serializer->serialize($excercises, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['categories', 'url']]);
        


        return new JsonResponse($json, 200, [], true);
    }
}
