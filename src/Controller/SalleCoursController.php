<?php

namespace App\Controller;

use App\Entity\SalleCours;
use App\Form\SalleCoursType;
use App\Repository\SalleCoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/salle/cours')]
class SalleCoursController extends AbstractController
{
    #[Route('/', name: 'app_salle_cours_index', methods: ['GET'])]
    public function index(SalleCoursRepository $salleCoursRepository): Response
    {
        return $this->render('salle_cours/index.html.twig', [
            'salle_cours' => $salleCoursRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_salle_cours_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $salleCour = new SalleCours();
        $form = $this->createForm(SalleCoursType::class, $salleCour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($salleCour);
            $entityManager->flush();

            return $this->redirectToRoute('app_salle_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('salle_cours/new.html.twig', [
            'salle_cour' => $salleCour,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_salle_cours_show', methods: ['GET'])]
    public function show(SalleCours $salleCour): Response
    {
        return $this->render('salle_cours/show.html.twig', [
            'salle_cour' => $salleCour,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_salle_cours_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SalleCours $salleCour, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SalleCoursType::class, $salleCour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_salle_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('salle_cours/edit.html.twig', [
            'salle_cour' => $salleCour,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_salle_cours_delete', methods: ['POST'])]
    public function delete(Request $request, SalleCours $salleCour, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$salleCour->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($salleCour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_salle_cours_index', [], Response::HTTP_SEE_OTHER);
    }
}
