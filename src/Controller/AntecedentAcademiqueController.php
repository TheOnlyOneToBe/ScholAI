<?php

namespace App\Controller;

use App\Entity\AntecedentAcademique;
use App\Form\AntecedentAcademiqueType;
use App\Repository\AntecedentAcademiqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/antecedent')]
class AntecedentAcademiqueController extends AbstractController
{
    #[Route('/', name: 'app_antecedent_academique_index', methods: ['GET'])]
    public function index(AntecedentAcademiqueRepository $antecedentAcademiqueRepository): Response
    {
        return $this->render('antecedent_academique/index.html.twig', [
            'antecedent_academiques' => $antecedentAcademiqueRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_antecedent_academique_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $antecedentAcademique = new AntecedentAcademique();
        $form = $this->createForm(AntecedentAcademiqueType::class, $antecedentAcademique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($antecedentAcademique);
            $entityManager->flush();

            return $this->redirectToRoute('app_antecedent_academique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('antecedent_academique/new.html.twig', [
            'antecedent_academique' => $antecedentAcademique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_antecedent_academique_show', methods: ['GET'])]
    public function show(AntecedentAcademique $antecedentAcademique): Response
    {
        return $this->render('antecedent_academique/show.html.twig', [
            'antecedent_academique' => $antecedentAcademique,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_antecedent_academique_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AntecedentAcademique $antecedentAcademique, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AntecedentAcademiqueType::class, $antecedentAcademique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_antecedent_academique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('antecedent_academique/edit.html.twig', [
            'antecedent_academique' => $antecedentAcademique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_antecedent_academique_delete', methods: ['POST'])]
    public function delete(Request $request, AntecedentAcademique $antecedentAcademique, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$antecedentAcademique->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($antecedentAcademique);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_antecedent_academique_index', [], Response::HTTP_SEE_OTHER);
    }
}
