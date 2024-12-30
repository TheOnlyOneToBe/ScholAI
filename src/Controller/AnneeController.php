<?php

namespace App\Controller;

use App\Entity\Annee;
use App\Form\AnneeType;
use App\Repository\AnneeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/annee')]
class AnneeController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator
    ) {
    }

    #[Route('/', name: 'app_annee_index', methods: ['GET'])]
    public function index(AnneeRepository $anneeRepository): Response
    {
        return $this->render('annee/index.html.twig', [
            'annees' => $anneeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_annee_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $annee = new Annee();
        $form = $this->createForm(AnneeType::class, $annee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->persist($annee);
                $this->entityManager->flush();

                $this->addFlash('success', $this->translator->trans('flash.success.create', [
                    '%entity%' => $this->translator->trans('entity.annee')
                ]));

                return $this->redirectToRoute('app_annee_index');
            } catch (\Exception $e) {
                $this->addFlash('error', $this->translator->trans('flash.error.create', [
                    '%entity%' => $this->translator->trans('entity.annee')
                ]));
            }
        } elseif ($form->isSubmitted()) {
            $this->addFlash('error', $this->translator->trans('flash.error.form'));
        }

        return $this->render('annee/new.html.twig', [
            'annee' => $annee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_annee_show', methods: ['GET'])]
    public function show(Annee $annee): Response
    {
        return $this->render('annee/show.html.twig', [
            'annee' => $annee,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_annee_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Annee $annee): Response
    {
        $form = $this->createForm(AnneeType::class, $annee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->flush();

                $this->addFlash('success', $this->translator->trans('flash.success.update', [
                    '%entity%' => $this->translator->trans('entity.annee')
                ]));

                return $this->redirectToRoute('app_annee_index');
            } catch (\Exception $e) {
                $this->addFlash('error', $this->translator->trans('flash.error.update', [
                    '%entity%' => $this->translator->trans('entity.annee')
                ]));
            }
        } elseif ($form->isSubmitted()) {
            $this->addFlash('error', $this->translator->trans('flash.error.form'));
        }

        return $this->render('annee/edit.html.twig', [
            'annee' => $annee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_annee_delete', methods: ['POST'])]
    public function delete(Request $request, Annee $annee): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annee->getId(), $request->request->get('_token'))) {
            try {
                $this->entityManager->remove($annee);
                $this->entityManager->flush();

                $this->addFlash('success', $this->translator->trans('flash.success.delete', [
                    '%entity%' => $this->translator->trans('entity.annee')
                ]));
            } catch (\Exception $e) {
                $this->addFlash('error', $this->translator->trans('flash.error.delete', [
                    '%entity%' => $this->translator->trans('entity.annee')
                ]));
            }
        }

        return $this->redirectToRoute('app_annee_index');
    }
}
