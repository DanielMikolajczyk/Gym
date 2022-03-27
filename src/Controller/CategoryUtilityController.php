<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/category')]
class CategoryUtilityController extends AbstractController
{

    #[Route('/suggest', methods:['GET'])]
    public function getCategoriesSuggestions(Request $request, CategoryRepository $categoryRepository): Response
    {
        //Return if no parameters provided
        if(!$request->query->get('term')){
            return $this->json(['suggestions' => '']);
        }

        $categories = $categoryRepository->findAllNotFinalWhereNameLike($request->query->get('term'));

        //Return if no parameters found
        if(!$categories){
            return $this->json(['suggestions' => '']);    
        }

        $categoriesNames = [];
        foreach($categories as $categories){
            $categoriesNames[] = array(
                "tag"       => $categories->getName(),
                "value"     => $categories->getId(),
                "background"=> 'green',
                "color"     => 'white'
            );
        }

        return $this->json([
            'suggestions' => $categoriesNames
        ]);
    }

    #[Route('/suggest/final', methods:['GET'])]
    public function getCategoriesFinalSuggestions(Request $request, CategoryRepository $categoryRepository): Response
    {
        //Return if no parameters provided
        if(!$request->query->get('term')){
            return $this->json(['suggestions' => '']);
        }

        $categories = $categoryRepository->findAllFinalWhereNameLike($request->query->get('term'));

        //Return if no parameters found
        if(!$categories){
            return $this->json(['suggestions' => '']);    
        }

        $categoriesNames = [];
        foreach($categories as $categories){
            $categoriesNames[] = array(
                "tag"       => $categories->getName(),
                "value"     => $categories->getId(),
                "background"=> 'green',
                "color"     => 'white'
            );
        }

        return $this->json([
            'suggestions' => $categoriesNames
        ]);
    }
    
    #[Route('/{id}', methods:['GET'])]
    public function show(Category $category, SerializerInterface $serializer): Response
    {
        $categoryJson = $serializer->serialize(
            $category,
            'json',
            ['groups' => 'show_category']
        );

        return new JsonResponse($categoryJson, 200, [], true);
    }
}
