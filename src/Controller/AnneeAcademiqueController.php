<?php

namespace App\Controller;

use App\Entity\AnneeAcademique;
use App\Form\AnneeAcademiqueType;
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
    private string $entityName;

    public function __construct(TranslatorInterface $translator, RequestStack $requestStack)
    {
        $this->translator = $translator;
        $this->requestStack = $requestStack;
        $this->entityName = $this->translator->trans('entity.annee_academique');
    }

    #[Route('/', name: 'app_annee_academique_index', methods: ['GET'])]
    public function index(AnneeAcademiqueRepository $anneeAcademiqueRepository): Response
    {
        $anneeAcademiques = $anneeAcademiqueRepository->findBy([], ['YearStart' => 'DESC']);
        
        if (empty($anneeAcademiques)) {
            $this->addInfoFlash($this->translator->trans('flash.info.no_records', [
                '%entity%' => $this->entityName
            ]));
        }

        return $this->render('annee_academique/index.html.twig', [
            'annee_academiques' => $anneeAcademiques,
        ]);
    }

    #[Route('/new', name: 'app_annee_academique_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, AnneeAcademiqueRepository $repository): Response
    {
        $anneeAcademique = new AnneeAcademique();
        $form = $this->createForm(AnneeAcademiqueType::class, $anneeAcademique);
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            if($form->isValid()) {
                try {
                    // Si c'est marqué comme année courante, désactiver les autres
                    if ($anneeAcademique->isCurrent()) {
                        $repository->removeCurrentFlag();
                    }
                    $anneeAcademique->setCurrent(false);
                    $entityManager->persist($anneeAcademique);
                    $entityManager->flush();

                    $this->addSuccessFlash($this->translator->trans('flash.success.item_created', [
                        '%entity%' => $this->entityName . ' ' . $anneeAcademique->getYearStart()->format('Y') . '-' . $anneeAcademique->getYearEnd()->format('Y')
                    ]));
                    return $this->redirectToRoute('app_annee_academique_index', [], Response::HTTP_SEE_OTHER);
                } catch (\Exception $e) {
                    $this->handleException($e);
                }
            } else {

                $errors = [];
                foreach ($form->getErrors(true, true) as $error) {
                    $errors[] = $error->getMessage();
                }
                $this->addFlash('error', implode('</br> ', $errors));
                $form->clearErrors();

            }
        }

        return $this->render('annee_academique/new.html.twig', [
            'annee_academique' => $anneeAcademique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_annee_academique_show', methods: ['GET'])]
    public function show(AnneeAcademique $anneeAcademique = null): Response
    {
        if (!$anneeAcademique) {
            throw $this->createNotFoundException($this->translator->trans('error.not_found', [
                'item' => $this->entityName
            ]));
        }

        return $this->render('annee_academique/show.html.twig', [
            'annee_academique' => $anneeAcademique,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_annee_academique_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AnneeAcademique $anneeAcademique, EntityManagerInterface $entityManager, AnneeAcademiqueRepository $repository): Response
    {
        $form = $this->createForm(AnneeAcademiqueType::class, $anneeAcademique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // Si c'est marqué comme année courante, désactiver les autres
                if ($anneeAcademique->isCurrent()) {
                    $repository->removeCurrentFlag($anneeAcademique->getId());
                }

                $entityManager->flush();
                $this->addSuccessFlash($this->translator->trans('flash.success.item_updated', [
                    '%entity%' => $this->entityName . ' ' . $anneeAcademique->getYearStart()->format('Y') . '-' . $anneeAcademique->getYearEnd()->format('Y')
                ]));
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
                // Empêcher la suppression de l'année académique courante
                if ($anneeAcademique->isCurrent()) {
                    throw new \Exception($this->translator->trans('error.cannot_delete_current_year'));
                }

                $entityManager->remove($anneeAcademique);
                $entityManager->flush();
                $this->addSuccessFlash($this->translator->trans('flash.success.item_deleted', [
                    '%entity%' => $this->entityName . ' ' . $anneeAcademique->getYearStart()->format('Y') . '-' . $anneeAcademique->getYearEnd()->format('Y')
                ]));
            } catch (\Exception $e) {
                $this->handleException($e);
            }
        }

        return $this->redirectToRoute('app_annee_academique_index', [], Response::HTTP_SEE_OTHER);
    }

    private function hasDependendencies(AnneeAcademique $anneeAcademique): bool
    {
        // Vérifier les relations (à implémenter selon vos besoins)
        return false;
    }
}
