<?php

namespace App\Controller;

use App\Entity\AnneeAcademique;
use App\Form\AnneeAcademiqueType;
use App\Repository\AnneeAcademiqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Trait\FlashMessageTrait;
use App\Controller\Trait\ErrorHandlerTrait;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/annee/academique')]
class AnneeAcademiqueController extends AbstractController
{
    use FlashMessageTrait;
    use ErrorHandlerTrait;

    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    #[Route('/', name: 'app_annee_academique_index', methods: ['GET'])]
    public function index(AnneeAcademiqueRepository $anneeAcademiqueRepository): Response
    {
        $anneeAcademiques = $anneeAcademiqueRepository->findAll();
        
        if (empty($anneeAcademiques)) {
            $this->addInfoFlash($this->translator->trans('flash.info.no_records'));
        }

        return $this->render('annee_academique/index.html.twig', [
            'annee_academiques' => $anneeAcademiques,
        ]);
    }

    #[Route('/new', name: 'app_annee_academique_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        try {
            $anneeAcademique = new AnneeAcademique();
            $form = $this->createForm(AnneeAcademiqueType::class, $anneeAcademique);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($anneeAcademique);
                $entityManager->flush();

                $this->addSuccessFlash($this->translator->trans('flash.success.created', [
                    '%entity%' => $this->translator->trans('entity.annee_academique')
                ]));

                return $this->redirectToRoute('app_annee_academique_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('annee_academique/new.html.twig', [
                'annee_academique' => $anneeAcademique,
                'form' => $form,
            ]);
        } catch (\Exception $e) {
            $this->addErrorFlash($this->translator->trans('flash.error.create_error', [
                '%entity%' => $this->translator->trans('entity.annee_academique')
            ]));
            return $this->redirectToRoute('app_annee_academique_index');
        }
    }

    #[Route('/{id}', name: 'app_annee_academique_show', methods: ['GET'])]
    public function show(AnneeAcademique $anneeAcademique = null): Response
    {
        if (!$anneeAcademique) {
            $this->handleNotFoundException('annee_academique');
        }

        return $this->render('annee_academique/show.html.twig', [
            'annee_academique' => $anneeAcademique,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_annee_academique_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AnneeAcademique $anneeAcademique = null, EntityManagerInterface $entityManager): Response
    {
        if (!$anneeAcademique) {
            $this->handleNotFoundException('annee_academique');
        }

        try {
            $form = $this->createForm(AnneeAcademiqueType::class, $anneeAcademique);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();

                $this->addSuccessFlash($this->translator->trans('flash.success.updated', [
                    '%entity%' => $this->translator->trans('entity.annee_academique')
                ]));

                return $this->redirectToRoute('app_annee_academique_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('annee_academique/edit.html.twig', [
                'annee_academique' => $anneeAcademique,
                'form' => $form,
            ]);
        } catch (\Exception $e) {
            $this->addErrorFlash($this->translator->trans('flash.error.update_error', [
                '%entity%' => $this->translator->trans('entity.annee_academique')
            ]));
            return $this->redirectToRoute('app_annee_academique_index');
        }
    }

    #[Route('/{id}', name: 'app_annee_academique_delete', methods: ['POST'])]
    public function delete(Request $request, AnneeAcademique $anneeAcademique = null, EntityManagerInterface $entityManager): Response
    {
        if (!$anneeAcademique) {
            $this->handleNotFoundException('annee_academique');
        }

        try {
            if ($this->isCsrfTokenValid('delete'.$anneeAcademique->getId(), $request->request->get('_token'))) {
                $entityManager->remove($anneeAcademique);
                $entityManager->flush();

                $this->addSuccessFlash($this->translator->trans('flash.success.deleted', [
                    '%entity%' => $this->translator->trans('entity.annee_academique')
                ]));
            }
        } catch (\Exception $e) {
            $this->addErrorFlash($this->translator->trans('flash.error.delete_error', [
                '%entity%' => $this->translator->trans('entity.annee_academique')
            ]));
        }

        return $this->redirectToRoute('app_annee_academique_index', [], Response::HTTP_SEE_OTHER);
    }
}
