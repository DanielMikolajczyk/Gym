<?php

namespace App\Controller;

use App\Entity\Workout;
use App\Repository\CategoryRepository;
use App\Repository\ExcerciseRepository;
use App\Repository\UserGroupRepository;
use App\Repository\UserRepository;
use App\Repository\WorkoutKindRepository;
use Doctrine\ORM\EntityManagerInterface;
use Flasher\Prime\FlasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Knp\Snappy\Pdf;
use Symfony\WebpackEncoreBundle\Asset\EntrypointLookupInterface;

#[Route('/workout')]
class WorkoutController extends AbstractController
{
    public function __construct(
        private WorkoutKindRepository $workoutKindRepository,
        private CategoryRepository $categoryRepository,
        private FlasherInterface $flasher
    )
    {}

    #[Route('/', name: 'workout_index')]
    public function index(): Response
    {
        return $this->render('workout/index.html.twig', [
            'controller_name' => 'WorkoutController',
        ]);
    }

    #[Route('/new', name: 'workout_new', methods:['GET'])]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        return $this->render('workout/new.html.twig',[
            'workoutKinds' => $this->workoutKindRepository->findAll(),
            'mainCategories' => $this->categoryRepository->findBy(['main'=>true]),
        ]);
    }

    #[Route('/create', name: 'workout_create', methods: ['POST'])]
    public function create(Request $request,UserRepository $userRepository, EntityManagerInterface $em, Environment $twig, Pdf $pdf, ExcerciseRepository $excerciseRepository, WorkoutKindRepository $workoutKindRepository, UserGroupRepository $userGroupRepository): Response
    {
        //TODO CSRF PROTECTION
        if(!$request->request->get('workoutName')){
            $this->flasher->addError('Wprowadź nazwę treningu!');
            return $this->redirectToRoute("workout_new");
        }else if(!$request->request->get('workoutUsers') && !$request->request->get('workoutGroups')){
            $this->flasher->addError('Wprowadź grupę, lub osoby!');
            return $this->redirectToRoute("workout_new");
        }
       
        $workout = new Workout();
        $workout->setName($request->request->get('workoutName'));
        $workoutKind = $workoutKindRepository->findOneBy(['id' => $request->request->get('workoutKind')]);
        $workout->setWorkoutKind($workoutKind);
        //Add users
        if($request->get('workoutUsers')){   
            $users = explode(',',$request->get('workoutUsers'));
            $usersArray = $userRepository->findBy(['id' => $users]);
            foreach($usersArray as $user){
                $workout->addUser($user);
            }
        }
        //Add groups
        if($request->get('workoutGroups')){   
            $groups = explode(',',$request->get('workoutGroups'));
            $groupsArray = $userGroupRepository->findBy(['id' => $groups]);
            foreach($groupsArray as $group){
                $workout->addUserGroup($group);
            }
        }
        $workout->setPlan($request->get('plan'));
        $plan = $request->get('plan');
        foreach($plan as $mainCategory => $content){
            $indexGroup = 0;
            foreach($content as $group){
                foreach($group as $indexRow => $data){
                    if(is_array($data)){
                        $plan[$mainCategory][$indexGroup][$indexRow]['excercise'] = $excerciseRepository->findOneBy(['id' => $data['excercise']])->getName();
                    }
                }
                $indexGroup++;
            }
        }
        //return $this->render('pdf/workout_html.html.twig',['plan'  => $plan]);
        $html = $twig->render('pdf/workout_html.html.twig',[
            'kind'  => $workoutKind->getName(),
            'plan'  => $plan,
        ]);
        date_default_timezone_set('Europe/Warsaw');
        if($request->get('workoutUsers')){
            foreach($usersArray as $user){
                $pdf->generateFromHtml($html, 'pdf/users/'.$user->getId().'-'.$user->getFullName().'/'.date('Y-m-d-H-i-s').'.pdf');
            }
        }
        if($request->get('workoutGroups')){
            foreach($groupsArray as $group){
                $pdf->generateFromHtml($html, 'pdf/groups/'.$group->getId().'-'.$group->getName().'/'.date('Y-m-d-H-i-s').'.pdf');
            }
        }

        $em->persist($workout);
        $em->flush();

        $this->flasher->addSuccess('Udało się stworzyć nowy plan terningowy!');
        return $this->redirectToRoute("workout_new");
    }
}