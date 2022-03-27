<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/user')]
class UserUtilityController extends AbstractController
{
    #[Route('/suggest', methods: ['GET'])]
    public function getUsersSuggestions(Request $request, UserRepository $userRepository)
    {
        //Return if no parameters provided
        if(!$request->query->get('term')){
            return $this->json(['suggestions' => '']);
        }

        $users = $userRepository->findAllWhereNameLike($request->query->get('term'));

        //Return if no parameters found
        if(!$users){
            return $this->json(['suggestions' => '']);    
        }

        foreach($users as $user){
            $userNames[] = array(
                "tag"       => $user->getFullName(),
                "value"     => $user->getId(),
                "background"=> 'green',
                "color"     => 'white'
            );
        }

        return $this->json([
            'suggestions' => $userNames
        ]);
    }
}
