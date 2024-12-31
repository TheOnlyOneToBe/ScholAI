<?php

namespace App\Controller;

use App\Entity\AnneeAcademique;
use App\Form\AnneeAcademiqueNoEntityType;
use App\Repository\AnneeAcademiqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Trait\FlashMessageTrait;
use App\Controller\Trait\ErrorHandlerTrait;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/annee')]
class AnneeAcademiqueController extends AbstractController
{
    use FlashMessageTrait;
    use ErrorHandlerTrait;

    private TranslatorInterface $translator;
    private RequestStack $requestStack;

    public function __construct(TranslatorInterface $translator, RequestStack $requestStack)
    {
        $this->translator = $translator;
        $this->requestStack = $requestStack;
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
        $form = $this->createForm(AnneeAcademiqueNoEntityType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            $anneeAcademique = new AnneeAcademique();
            $anneeAcademique->setYearStart($data['YearStart']);
            $anneeAcademique->setYearEnd($data['YearEnd']);
            $anneeAcademique->setIsCurrent(false);

            try {
                $entityManager->persist($anneeAcademique);
                $entityManager->flush();
                $this->addSuccessFlash($this->translator->trans('flash.success.item_created'));
                return $this->redirectToRoute('app_annee_academique_index', [], Response::HTTP_SEE_OTHER);
            } catch (\Exception $e) {
                $this->handleException($e);
            }
        }

        return $this->render('annee_academique/new.html.twig', [
            'form' => $form,
        ]);
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
    public function edit(Request $request, AnneeAcademique $anneeAcademique, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AnneeAcademiqueNoEntityType::class, [
            'YearStart' => $anneeAcademique->getYearStart(),
            'YearEnd' => $anneeAcademique->getYearEnd()
        ]);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            $anneeAcademique->setYearStart($data['YearStart']);
            $anneeAcademique->setYearEnd($data['YearEnd']);

            try {
                $entityManager->flush();
                $this->addSuccessFlash($this->translator->trans('flash.success.item_updated'));
                return $this->redirectToRoute('app_annee_academique_index', [], Response::HTTP_SEE_OTHER);
            } catch (\Exception $e) {
                $this->handleException($e);
            }
        }

        return $this->render('annee_academique/edit.html.twig', [
            'annee_academique' => $anneeAcademique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_annee_academique_delete', methods: ['POST'])]
    public function delete(Request $request, AnneeAcademique $anneeAcademique, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$anneeAcademique->getId(), $request->request->get('_token'))) {
            try {
                $entityManager->remove($anneeAcademique);
                $entityManager->flush();
                $this->addSuccessFlash($this->translator->trans('flash.success.item_deleted'));
            } catch (\Exception $e) {
                $this->handleException($e);
            }
        }

        return $this->redirectToRoute('app_annee_academique_index', [], Response::HTTP_SEE_OTHER);
    }
}
