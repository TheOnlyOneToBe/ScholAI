<?php

namespace App\Controller;

use App\Entity\Payementreason;
use App\Form\PayementreasonType;
use App\Repository\PayementreasonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/payementreason')]
class PayementreasonController extends AbstractController
{
    #[Route('/', name: 'app_payementreason_index', methods: ['GET'])]
    public function index(PayementreasonRepository $payementreasonRepository): Response
    {
        return $this->render('payementreason/index.html.twig', [
            'payementreasons' => $payementreasonRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_payementreason_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $payementreason = new Payementreason();
        $form = $this->createForm(PayementreasonType::class, $payementreason);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($payementreason);
            $entityManager->flush();

            return $this->redirectToRoute('app_payementreason_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('payementreason/new.html.twig', [
            'payementreason' => $payementreason,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_payementreason_show', methods: ['GET'])]
    public function show(Payementreason $payementreason): Response
    {
        return $this->render('payementreason/show.html.twig', [
            'payementreason' => $payementreason,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_payementreason_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Payementreason $payementreason, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PayementreasonType::class, $payementreason);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_payementreason_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('payementreason/edit.html.twig', [
            'payementreason' => $payementreason,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_payementreason_delete', methods: ['POST'])]
    public function delete(Request $request, Payementreason $payementreason, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$payementreason->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($payementreason);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_payementreason_index', [], Response::HTTP_SEE_OTHER);
    }
}
