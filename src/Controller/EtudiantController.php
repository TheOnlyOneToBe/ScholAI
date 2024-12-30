<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/etudiant')]
class EtudiantController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator
    ) {
    }

    #[Route('/', name: 'app_etudiant_index', methods: ['GET'])]
    public function index(EtudiantRepository $etudiantRepository): Response
    {
        return $this->render('etudiant/index.html.twig', [
            'etudiants' => $etudiantRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_etudiant_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->persist($etudiant);
                $this->entityManager->flush();

                $this->addFlash('success', $this->translator->trans('flash.success.create', [
                    '%entity%' => $this->translator->trans('entity.etudiant')
                ]));

                return $this->redirectToRoute('app_etudiant_index');
            } catch (\Exception $e) {
                $this->addFlash('error', $this->translator->trans('flash.error.create', [
                    '%entity%' => $this->translator->trans('entity.etudiant')
                ]));
            }
        } elseif ($form->isSubmitted()) {
            $this->addFlash('error', $this->translator->trans('flash.error.form'));
        }

        return $this->render('etudiant/new.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etudiant_show', methods: ['GET'])]
    public function show(Etudiant $etudiant): Response
    {
        return $this->render('etudiant/show.html.twig', [
            'etudiant' => $etudiant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_etudiant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Etudiant $etudiant): Response
    {
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->flush();

                $this->addFlash('success', $this->translator->trans('flash.success.update', [
                    '%entity%' => $this->translator->trans('entity.etudiant')
                ]));

                return $this->redirectToRoute('app_etudiant_index');
            } catch (\Exception $e) {
                $this->addFlash('error', $this->translator->trans('flash.error.update', [
                    '%entity%' => $this->translator->trans('entity.etudiant')
                ]));
            }
        } elseif ($form->isSubmitted()) {
            $this->addFlash('error', $this->translator->trans('flash.error.form'));
        }

        return $this->render('etudiant/edit.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etudiant_delete', methods: ['POST'])]
    public function delete(Request $request, Etudiant $etudiant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etudiant->getId(), $request->request->get('_token'))) {
            try {
                $this->entityManager->remove($etudiant);
                $this->entityManager->flush();

                $this->addFlash('success', $this->translator->trans('flash.success.delete', [
                    '%entity%' => $this->translator->trans('entity.etudiant')
                ]));
            } catch (\Exception $e) {
                $this->addFlash('error', $this->translator->trans('flash.error.delete', [
                    '%entity%' => $this->translator->trans('entity.etudiant')
                ]));
            }
        }

        return $this->redirectToRoute('app_etudiant_index');
    }
}
