<?php

namespace App\Controller;

use App\Entity\PayementReason;
use App\Form\PayementReasonType;
use App\Repository\PayementReasonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/payementreason')]
class PayementReasonController extends AbstractController
{
    #[Route('/', name: 'app_payement_reason_index', methods: ['GET'])]
    public function index(PayementReasonRepository $payementReasonRepository): Response
    {
        return $this->render('payement_reason/index.html.twig', [
            'payement_reasons' => $payementReasonRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_payement_reason_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $payementReason = new PayementReason();
        $form = $this->createForm(PayementReasonType::class, $payementReason);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($payementReason);
            $entityManager->flush();

            return $this->redirectToRoute('app_payement_reason_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('payement_reason/new.html.twig', [
            'payement_reason' => $payementReason,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_payement_reason_show', methods: ['GET'])]
    public function show(PayementReason $payementReason): Response
    {
        return $this->render('payement_reason/show.html.twig', [
            'payement_reason' => $payementReason,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_payement_reason_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PayementReason $payementReason, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PayementReasonType::class, $payementReason);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_payement_reason_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('payement_reason/edit.html.twig', [
            'payement_reason' => $payementReason,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_payement_reason_delete', methods: ['POST'])]
    public function delete(Request $request, PayementReason $payementReason, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$payementReason->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($payementReason);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_payement_reason_index', [], Response::HTTP_SEE_OTHER);
    }
}
