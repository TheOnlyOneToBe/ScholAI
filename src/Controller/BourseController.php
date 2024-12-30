<?php

namespace App\Controller;

use App\Entity\Bourse;
use App\Form\BourseType;
use App\Repository\BourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/bourse')]
class BourseController extends AbstractController
{
    #[Route('/', name: 'app_bourse_index', methods: ['GET'])]
    public function index(BourseRepository $bourseRepository): Response
    {
        return $this->render('bourse/index.html.twig', [
            'bourses' => $bourseRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_bourse_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bourse = new Bourse();
        $form = $this->createForm(BourseType::class, $bourse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bourse);
            $entityManager->flush();

            return $this->redirectToRoute('app_bourse_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bourse/new.html.twig', [
            'bourse' => $bourse,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bourse_show', methods: ['GET'])]
    public function show(Bourse $bourse): Response
    {
        return $this->render('bourse/show.html.twig', [
            'bourse' => $bourse,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bourse_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bourse $bourse, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BourseType::class, $bourse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_bourse_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('bourse/edit.html.twig', [
            'bourse' => $bourse,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bourse_delete', methods: ['POST'])]
    public function delete(Request $request, Bourse $bourse, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bourse->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bourse);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_bourse_index', [], Response::HTTP_SEE_OTHER);
    }
}
