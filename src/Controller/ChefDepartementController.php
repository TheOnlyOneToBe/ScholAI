<?php

namespace App\Controller;

use App\Entity\ChefDepartement;
use App\Form\ChefDepartementType;
use App\Repository\ChefDepartementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/chef/departement')]
class ChefDepartementController extends AbstractController
{
    #[Route('/', name: 'app_chef_departement_index', methods: ['GET'])]
    public function index(ChefDepartementRepository $chefDepartementRepository): Response
    {
        return $this->render('chef_departement/index.html.twig', [
            'chef_departements' => $chefDepartementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_chef_departement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $chefDepartement = new ChefDepartement();
        $form = $this->createForm(ChefDepartementType::class, $chefDepartement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($chefDepartement);
            $entityManager->flush();

            return $this->redirectToRoute('app_chef_departement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chef_departement/new.html.twig', [
            'chef_departement' => $chefDepartement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_chef_departement_show', methods: ['GET'])]
    public function show(ChefDepartement $chefDepartement): Response
    {
        return $this->render('chef_departement/show.html.twig', [
            'chef_departement' => $chefDepartement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_chef_departement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ChefDepartement $chefDepartement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChefDepartementType::class, $chefDepartement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_chef_departement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chef_departement/edit.html.twig', [
            'chef_departement' => $chefDepartement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_chef_departement_delete', methods: ['POST'])]
    public function delete(Request $request, ChefDepartement $chefDepartement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chefDepartement->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($chefDepartement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_chef_departement_index', [], Response::HTTP_SEE_OTHER);
    }
}
