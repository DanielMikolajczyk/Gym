<?php

namespace App\Controller;

use App\Entity\WorkoutKind;
use App\Form\WorkoutKindType;
use App\Repository\WorkoutKindRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/workoutkind')]
class WorkoutKindController extends AbstractController
{
    #[Route('/', name: 'workout_kind_index', methods: ['GET'])]
    public function index(WorkoutKindRepository $workoutKindRepository): Response
    {
        return $this->render('workout_kind/index.html.twig', [
            'workout_kinds' => $workoutKindRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'workout_kind_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $workoutKind = new WorkoutKind();
        $form = $this->createForm(WorkoutKindType::class, $workoutKind);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($workoutKind);
            $entityManager->flush();

            return $this->redirectToRoute('workout_kind_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('workout_kind/new.html.twig', [
            'workout_kind' => $workoutKind,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'workout_kind_show', methods: ['GET'])]
    public function show(WorkoutKind $workoutKind): Response
    {
        return $this->render('workout_kind/show.html.twig', [
            'workout_kind' => $workoutKind,
        ]);
    }

    #[Route('/{id}/edit', name: 'workout_kind_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, WorkoutKind $workoutKind, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(WorkoutKindType::class, $workoutKind);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('workout_kind_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('workout_kind/edit.html.twig', [
            'workout_kind' => $workoutKind,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'workout_kind_delete', methods: ['POST'])]
    public function delete(Request $request, WorkoutKind $workoutKind, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$workoutKind->getId(), $request->request->get('_token'))) {
            $entityManager->remove($workoutKind);
            $entityManager->flush();
        }

        return $this->redirectToRoute('workout_kind_index', [], Response::HTTP_SEE_OTHER);
    }
}
