<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Form\DepartementType;
use App\Repository\DepartementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Trait\FlashMessageTrait;
use App\Controller\Trait\ErrorHandlerTrait;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

#[Route('/departement')]
class DepartementController extends AbstractController
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
        $this->entityName = $this->translator->trans('entity.departement');
    }

    #[Route('/', name: 'app_departement_index', methods: ['GET'])]
    public function index(DepartementRepository $departementRepository): Response
    {
        $departements = $departementRepository->findAll();
        
        if (empty($departements)) {
            $this->addInfoFlash($this->translator->trans('flash.info.no_records', [
                '%entity%' => $this->entityName
            ]));
        }

        return $this->render('departement/index.html.twig', [
            'departements' => $departements,
        ]);
    }

    #[Route('/new', name: 'app_departement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $departement = new Departement();
        $form = $this->createForm(DepartementType::class, $departement);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $entityManager->persist($departement);
                    $entityManager->flush();

                    $this->addSuccessFlash($this->translator->trans('flash.success.item_created', [
                        '%entity%' => $this->entityName . ' ' . $departement->getNomDepartement()
                    ]));

                    return $this->redirectToRoute('app_departement_index', [], Response::HTTP_SEE_OTHER);
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

        return $this->render('departement/new.html.twig', [
            'departement' => $departement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_departement_show', methods: ['GET'])]
    public function show(Departement $departement = null): Response
    {
        if (!$departement) {
            $this->handleNotFoundException('departement');
        }

        return $this->render('departement/show.html.twig', [
            'departement' => $departement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_departement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Departement $departement = null, EntityManagerInterface $entityManager): Response
    {
        if (!$departement) {
            $this->handleNotFoundException('departement');
        }

        try {
            $form = $this->createForm(DepartementType::class, $departement);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();

                $this->addSuccessFlash($this->translator->trans('flash.success.updated', [
                    '%entity%' => $this->translator->trans('entity.departement')
                ]));

                return $this->redirectToRoute('app_departement_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('departement/edit.html.twig', [
                'departement' => $departement,
                'form' => $form,
            ]);
        } catch (\Exception $e) {
            $this->addErrorFlash($this->translator->trans('flash.error.update_error', [
                '%entity%' => $this->translator->trans('entity.departement')
            ]));
            return $this->redirectToRoute('app_departement_index');
        }
    }

    #[Route('/{id}', name: 'app_departement_delete', methods: ['POST'])]
    public function delete(Request $request, Departement $departement = null, EntityManagerInterface $entityManager): Response
    {
        if (!$departement) {
            $this->handleNotFoundException('departement');
        }

        try {
            if ($this->isCsrfTokenValid('delete'.$departement->getId(), $request->request->get('_token'))) {
                $entityManager->remove($departement);
                $entityManager->flush();

                $this->addSuccessFlash($this->translator->trans('flash.success.deleted', [
                    '%entity%' => $this->translator->trans('entity.departement')
                ]));
            }
        } catch (\Exception $e) {
            $this->addErrorFlash($this->translator->trans('flash.error.delete_error', [
                '%entity%' => $this->translator->trans('entity.departement')
            ]));
        }

        return $this->redirectToRoute('app_departement_index', [], Response::HTTP_SEE_OTHER);
    }
}
