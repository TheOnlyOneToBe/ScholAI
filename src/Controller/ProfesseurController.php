<?php

namespace App\Controller;

use App\Entity\Professeur;
use App\Form\ProfesseurType;
use App\Repository\ProfesseurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/professeur')]
class ProfesseurController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator
    ) {
    }

    #[Route('/', name: 'app_professeur_index', methods: ['GET'])]
    public function index(ProfesseurRepository $professeurRepository): Response
    {
        return $this->render('professeur/index.html.twig', [
            'professeurs' => $professeurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_professeur_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $professeur = new Professeur();
        $form = $this->createForm(ProfesseurType::class, $professeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->persist($professeur);
                $this->entityManager->flush();

                $this->addFlash('success', $this->translator->trans('flash.success.create', [
                    '%entity%' => $this->translator->trans('entity.professeur')
                ]));

                return $this->redirectToRoute('app_professeur_index');
            } catch (\Exception $e) {
                $this->addFlash('error', $this->translator->trans('flash.error.create', [
                    '%entity%' => $this->translator->trans('entity.professeur')
                ]));
            }
        } elseif ($form->isSubmitted()) {
            $this->addFlash('error', $this->translator->trans('flash.error.form'));
        }

        return $this->render('professeur/new.html.twig', [
            'professeur' => $professeur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_professeur_show', methods: ['GET'])]
    public function show(Professeur $professeur): Response
    {
        return $this->render('professeur/show.html.twig', [
            'professeur' => $professeur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_professeur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Professeur $professeur): Response
    {
        $form = $this->createForm(ProfesseurType::class, $professeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->flush();

                $this->addFlash('success', $this->translator->trans('flash.success.update', [
                    '%entity%' => $this->translator->trans('entity.professeur')
                ]));

                return $this->redirectToRoute('app_professeur_index');
            } catch (\Exception $e) {
                $this->addFlash('error', $this->translator->trans('flash.error.update', [
                    '%entity%' => $this->translator->trans('entity.professeur')
                ]));
            }
        } elseif ($form->isSubmitted()) {
            $this->addFlash('error', $this->translator->trans('flash.error.form'));
        }

        return $this->render('professeur/edit.html.twig', [
            'professeur' => $professeur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_professeur_delete', methods: ['POST'])]
    public function delete(Request $request, Professeur $professeur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$professeur->getId(), $request->request->get('_token'))) {
            try {
                $this->entityManager->remove($professeur);
                $this->entityManager->flush();

                $this->addFlash('success', $this->translator->trans('flash.success.delete', [
                    '%entity%' => $this->translator->trans('entity.professeur')
                ]));
            } catch (\Exception $e) {
                $this->addFlash('error', $this->translator->trans('flash.error.delete', [
                    '%entity%' => $this->translator->trans('entity.professeur')
                ]));
            }
        }

        return $this->redirectToRoute('app_professeur_index');
    }
}
