<?php

namespace App\Controller;

use App\Entity\AnneeAcademique;
use App\Form\AnneeAcademiqueType;
use App\Repository\AnneeAcademiqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/annee')]
class AnneeAcademiqueController extends AbstractController
{
    #[Route('/', name: 'app_annee_academique_index', methods: ['GET'])]
    public function index(AnneeAcademiqueRepository $anneeAcademiqueRepository): Response
    {
        return $this->render('annee_academique/index.html.twig', [
            'annee_academiques' => $anneeAcademiqueRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_annee_academique_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $anneeAcademique = new AnneeAcademique();
        $form = $this->createForm(AnneeAcademiqueType::class, $anneeAcademique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($anneeAcademique);
            $entityManager->flush();

            return $this->redirectToRoute('app_annee_academique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('annee_academique/new.html.twig', [
            'annee_academique' => $anneeAcademique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_annee_academique_show', methods: ['GET'])]
    public function show(AnneeAcademique $anneeAcademique): Response
    {
        return $this->render('annee_academique/show.html.twig', [
            'annee_academique' => $anneeAcademique,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_annee_academique_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AnneeAcademique $anneeAcademique, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AnneeAcademiqueType::class, $anneeAcademique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_annee_academique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('annee_academique/edit.html.twig', [
            'annee_academique' => $anneeAcademique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_annee_academique_delete', methods: ['POST'])]
    public function delete(Request $request, AnneeAcademique $anneeAcademique, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$anneeAcademique->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($anneeAcademique);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_annee_academique_index', [], Response::HTTP_SEE_OTHER);
    }
}
