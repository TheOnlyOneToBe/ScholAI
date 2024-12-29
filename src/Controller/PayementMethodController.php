<?php

namespace App\Controller;

use App\Entity\PayementMethod;
use App\Form\PayementMethodType;
use App\Repository\PayementMethodRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/payementmethod')]
class PayementMethodController extends AbstractController
{
    #[Route('/', name: 'app_payement_method_index', methods: ['GET'])]
    public function index(PayementMethodRepository $payementMethodRepository): Response
    {
        return $this->render('payement_method/index.html.twig', [
            'payement_methods' => $payementMethodRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_payement_method_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $payementMethod = new PayementMethod();
        $form = $this->createForm(PayementMethodType::class, $payementMethod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($payementMethod);
            $entityManager->flush();

            return $this->redirectToRoute('app_payement_method_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('payement_method/new.html.twig', [
            'payement_method' => $payementMethod,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_payement_method_show', methods: ['GET'])]
    public function show(PayementMethod $payementMethod): Response
    {
        return $this->render('payement_method/show.html.twig', [
            'payement_method' => $payementMethod,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_payement_method_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PayementMethod $payementMethod, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PayementMethodType::class, $payementMethod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_payement_method_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('payement_method/edit.html.twig', [
            'payement_method' => $payementMethod,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_payement_method_delete', methods: ['POST'])]
    public function delete(Request $request, PayementMethod $payementMethod, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$payementMethod->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($payementMethod);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_payement_method_index', [], Response::HTTP_SEE_OTHER);
    }
}
