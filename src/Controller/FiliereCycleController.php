<?php

namespace App\Controller;

use App\Entity\FiliereCycle;
use App\Form\FiliereCycleType;
use App\Repository\FiliereCycleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/specialite')]
final class FiliereCycleController extends AbstractController
{
    #[Route(name: 'app_filiere_cycle_index', methods: ['GET'])]
    public function index(FiliereCycleRepository $filiereCycleRepository): Response
    {
        return $this->render('filiere_cycle/index.html.twig', [
            'filiere_cycles' => $filiereCycleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_filiere_cycle_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $filiereCycle = new FiliereCycle();
        $form = $this->createForm(FiliereCycleType::class, $filiereCycle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($filiereCycle);
            $entityManager->flush();

            return $this->redirectToRoute('app_filiere_cycle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('filiere_cycle/new.html.twig', [
            'filiere_cycle' => $filiereCycle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_filiere_cycle_show', methods: ['GET'])]
    public function show(FiliereCycle $filiereCycle): Response
    {
        return $this->render('filiere_cycle/show.html.twig', [
            'filiere_cycle' => $filiereCycle,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_filiere_cycle_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FiliereCycle $filiereCycle, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FiliereCycleType::class, $filiereCycle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_filiere_cycle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('filiere_cycle/edit.html.twig', [
            'filiere_cycle' => $filiereCycle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_filiere_cycle_delete', methods: ['POST'])]
    public function delete(Request $request, FiliereCycle $filiereCycle, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$filiereCycle->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($filiereCycle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_filiere_cycle_index', [], Response::HTTP_SEE_OTHER);
    }
}
