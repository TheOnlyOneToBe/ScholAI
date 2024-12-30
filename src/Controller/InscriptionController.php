<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Form\InscriptionType;
use App\Repository\InscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/inscription')]
class InscriptionController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator
    ) {
    }

    #[Route('/', name: 'app_inscription_index', methods: ['GET'])]
    public function index(InscriptionRepository $inscriptionRepository): Response
    {
        return $this->render('inscription/index.html.twig', [
            'inscriptions' => $inscriptionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_inscription_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $inscription = new Inscription();
        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $inscription->setDateInscription(new \DateTime());
                $inscription->setStatutInscription(true);
                
                $this->entityManager->persist($inscription);
                $this->entityManager->flush();

                $this->addFlash('success', $this->translator->trans('flash.success.create', [
                    '%entity%' => $this->translator->trans('entity.inscription')
                ]));

                return $this->redirectToRoute('app_inscription_index');
            } catch (\Exception $e) {
                $this->addFlash('error', $this->translator->trans('flash.error.create', [
                    '%entity%' => $this->translator->trans('entity.inscription')
                ]));
            }
        } elseif ($form->isSubmitted()) {
            $this->addFlash('error', $this->translator->trans('flash.error.form'));
        }

        return $this->render('inscription/new.html.twig', [
            'inscription' => $inscription,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_inscription_show', methods: ['GET'])]
    public function show(Inscription $inscription): Response
    {
        return $this->render('inscription/show.html.twig', [
            'inscription' => $inscription,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_inscription_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Inscription $inscription): Response
    {
        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->flush();

                $this->addFlash('success', $this->translator->trans('flash.success.update', [
                    '%entity%' => $this->translator->trans('entity.inscription')
                ]));

                return $this->redirectToRoute('app_inscription_index');
            } catch (\Exception $e) {
                $this->addFlash('error', $this->translator->trans('flash.error.update', [
                    '%entity%' => $this->translator->trans('entity.inscription')
                ]));
            }
        } elseif ($form->isSubmitted()) {
            $this->addFlash('error', $this->translator->trans('flash.error.form'));
        }

        return $this->render('inscription/edit.html.twig', [
            'inscription' => $inscription,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_inscription_delete', methods: ['POST'])]
    public function delete(Request $request, Inscription $inscription): Response
    {
        if ($this->isCsrfTokenValid('delete'.$inscription->getId(), $request->request->get('_token'))) {
            try {
                $this->entityManager->remove($inscription);
                $this->entityManager->flush();

                $this->addFlash('success', $this->translator->trans('flash.success.delete', [
                    '%entity%' => $this->translator->trans('entity.inscription')
                ]));
            } catch (\Exception $e) {
                $this->addFlash('error', $this->translator->trans('flash.error.delete', [
                    '%entity%' => $this->translator->trans('entity.inscription')
                ]));
            }
        }

        return $this->redirectToRoute('app_inscription_index');
    }
}
