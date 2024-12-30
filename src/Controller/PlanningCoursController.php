<?php

namespace App\Controller;

use App\Entity\PlanningCours;
use App\Form\PlanningCoursType;
use App\Repository\PlanningCoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/planning/cours')]
class PlanningCoursController extends AbstractController
{
    #[Route('/', name: 'app_planning_cours_index', methods: ['GET'])]
    public function index(PlanningCoursRepository $planningCoursRepository): Response
    {
        return $this->render('planning_cours/index.html.twig', [
            'planning_cours' => $planningCoursRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_planning_cours_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $planningCour = new PlanningCours();
        $form = $this->createForm(PlanningCoursType::class, $planningCour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($planningCour);
            $entityManager->flush();

            return $this->redirectToRoute('app_planning_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('planning_cours/new.html.twig', [
            'planning_cour' => $planningCour,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_planning_cours_show', methods: ['GET'])]
    public function show(PlanningCours $planningCour): Response
    {
        return $this->render('planning_cours/show.html.twig', [
            'planning_cour' => $planningCour,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_planning_cours_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PlanningCours $planningCour, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlanningCoursType::class, $planningCour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_planning_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('planning_cours/edit.html.twig', [
            'planning_cour' => $planningCour,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_planning_cours_delete', methods: ['POST'])]
    public function delete(Request $request, PlanningCours $planningCour, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$planningCour->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($planningCour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_planning_cours_index', [], Response::HTTP_SEE_OTHER);
    }
}
