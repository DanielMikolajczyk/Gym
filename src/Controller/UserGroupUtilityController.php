<?php

namespace App\Controller;

use App\Repository\UserGroupRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/user-groups')]
class UserGroupUtilityController extends AbstractController
{
    #[Route('/suggest', methods: ['GET'])]
    public function getUserGroupsSuggestions(Request $request, UserGroupRepository $userGroupRepository)
    {
        //Return if no parameters provided
        if(!$request->query->get('term')){
            return $this->json(['suggestions' => '']);
        }

        $groups = $userGroupRepository->findAllWhereNameLike($request->query->get('term'));

        //Return if no parameters found
        if(!$groups){
            return $this->json(['suggestions' => '']);    
        }

        foreach($groups as $group){
            $groupNames[] = array(
                "tag"       => $group->getName(),
                "value"     => $group->getId(),
                "background"=> 'green',
                "color"     => 'white'
            );
        }

        return $this->json([
            'suggestions' => $groupNames
        ]);
    }
}
