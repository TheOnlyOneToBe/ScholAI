<?php

namespace App\Controller;

use App\Entity\TuteurEtudiant;
use App\Form\TuteurEtudiantType;
use App\Repository\TuteurEtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tuteur/etudiant')]
class TuteurEtudiantController extends AbstractController
{
    #[Route('/', name: 'app_tuteur_etudiant_index', methods: ['GET'])]
    public function index(TuteurEtudiantRepository $tuteurEtudiantRepository): Response
    {
        return $this->render('tuteur_etudiant/index.html.twig', [
            'tuteur_etudiants' => $tuteurEtudiantRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tuteur_etudiant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tuteurEtudiant = new TuteurEtudiant();
        $form = $this->createForm(TuteurEtudiantType::class, $tuteurEtudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tuteurEtudiant);
            $entityManager->flush();

            return $this->redirectToRoute('app_tuteur_etudiant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tuteur_etudiant/new.html.twig', [
            'tuteur_etudiant' => $tuteurEtudiant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tuteur_etudiant_show', methods: ['GET'])]
    public function show(TuteurEtudiant $tuteurEtudiant): Response
    {
        return $this->render('tuteur_etudiant/show.html.twig', [
            'tuteur_etudiant' => $tuteurEtudiant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tuteur_etudiant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TuteurEtudiant $tuteurEtudiant, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TuteurEtudiantType::class, $tuteurEtudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_tuteur_etudiant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tuteur_etudiant/edit.html.twig', [
            'tuteur_etudiant' => $tuteurEtudiant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tuteur_etudiant_delete', methods: ['POST'])]
    public function delete(Request $request, TuteurEtudiant $tuteurEtudiant, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tuteurEtudiant->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($tuteurEtudiant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_tuteur_etudiant_index', [], Response::HTTP_SEE_OTHER);
    }
}
