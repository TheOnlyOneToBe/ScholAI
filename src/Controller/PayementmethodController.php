<?php

namespace App\Controller;

use App\Entity\PayementMethod;
use App\Form\PayementmethodType;
use App\Repository\PayementmethodRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/payementmethod')]
final class PayementmethodController extends AbstractController
{
    #[Route(name: 'app_payementmethod_index', methods: ['GET'])]
    public function index(PayementmethodRepository $payementmethodRepository): Response
    {
        return $this->render('payementmethod/index.html.twig', [
            'payementmethods' => $payementmethodRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_payementmethod_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $payementmethod = new Payementmethod();
        $form = $this->createForm(PayementmethodType::class, $payementmethod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($payementmethod);
            $entityManager->flush();

            return $this->redirectToRoute('app_payementmethod_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('payementmethod/new.html.twig', [
            'payementmethod' => $payementmethod,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_payementmethod_show', methods: ['GET'])]
    public function show(Payementmethod $payementmethod): Response
    {
        return $this->render('payementmethod/show.html.twig', [
            'payementmethod' => $payementmethod,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_payementmethod_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Payementmethod $payementmethod, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PayementmethodType::class, $payementmethod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_payementmethod_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('payementmethod/edit.html.twig', [
            'payementmethod' => $payementmethod,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_payementmethod_delete', methods: ['POST'])]
    public function delete(Request $request, Payementmethod $payementmethod, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$payementmethod->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($payementmethod);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_payementmethod_index', [], Response::HTTP_SEE_OTHER);
    }
}
