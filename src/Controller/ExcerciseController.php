<?php

namespace App\Controller;

use App\Entity\Excercise;
use App\Form\ExcerciseType;
use App\Repository\ExcerciseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/excercise')]
class ExcerciseController extends AbstractController
{
    #[Route('/', name: 'excercise_index', methods: ['GET'])]
    public function index(ExcerciseRepository $excerciseRepository): Response
    {
        return $this->render('excercise/index.html.twig', [
            'excercises' => $excerciseRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'excercise_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $excercise = new Excercise();
        $form = $this->createForm(ExcerciseType::class, $excercise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($excercise);
            $entityManager->flush();

            return $this->redirectToRoute('excercise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('excercise/new.html.twig', [
            'excercise' => $excercise,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'excercise_show', methods: ['GET'])]
    public function show(Excercise $excercise): Response
    {
        return $this->render('excercise/show.html.twig', [
            'excercise' => $excercise,
        ]);
    }

    #[Route('/{id}/edit', name: 'excercise_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Excercise $excercise, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExcerciseType::class, $excercise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('excercise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('excercise/edit.html.twig', [
            'excercise' => $excercise,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'excercise_delete', methods: ['POST'])]
    public function delete(Request $request, Excercise $excercise, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$excercise->getId(), $request->request->get('_token'))) {
            $entityManager->remove($excercise);
            $entityManager->flush();
        }

        return $this->redirectToRoute('excercise_index', [], Response::HTTP_SEE_OTHER);
    }
}
