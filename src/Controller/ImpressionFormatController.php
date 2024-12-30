<?php

namespace App\Controller;

use App\Entity\ImpressionFormat;
use App\Form\ImpressionFormatType;
use App\Repository\ImpressionFormatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/impression/format')]
class ImpressionFormatController extends AbstractController
{
    #[Route('/', name: 'app_impression_format_index', methods: ['GET'])]
    public function index(ImpressionFormatRepository $impressionFormatRepository): Response
    {
        return $this->render('impression_format/index.html.twig', [
            'impression_formats' => $impressionFormatRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_impression_format_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $impressionFormat = new ImpressionFormat();
        $form = $this->createForm(ImpressionFormatType::class, $impressionFormat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($impressionFormat);
            $entityManager->flush();

            return $this->redirectToRoute('app_impression_format_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('impression_format/new.html.twig', [
            'impression_format' => $impressionFormat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_impression_format_show', methods: ['GET'])]
    public function show(ImpressionFormat $impressionFormat): Response
    {
        return $this->render('impression_format/show.html.twig', [
            'impression_format' => $impressionFormat,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_impression_format_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ImpressionFormat $impressionFormat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ImpressionFormatType::class, $impressionFormat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_impression_format_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('impression_format/edit.html.twig', [
            'impression_format' => $impressionFormat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_impression_format_delete', methods: ['POST'])]
    public function delete(Request $request, ImpressionFormat $impressionFormat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$impressionFormat->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($impressionFormat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_impression_format_index', [], Response::HTTP_SEE_OTHER);
    }
}
