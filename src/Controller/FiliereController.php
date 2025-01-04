<?php

namespace App\Controller;

use App\Entity\Filiere;
use App\Form\FiliereType;
use App\Repository\FiliereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Controller\Trait\FlashMessageTrait;
use App\Controller\Trait\ErrorHandlerTrait;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

#[Route('/filiere')]
final class FiliereController extends AbstractController
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
        $this->entityName = $this->translator->trans('entity.filiere');
    }

    #[Route('/', name: 'app_filiere_index', methods: ['GET'])]
    public function index(FiliereRepository $filiereRepository): Response
    {
        $filieres = $filiereRepository->findAll();
        
        if (empty($filieres)) {
            $this->addInfoFlash($this->translator->trans('flash.info.no_records', [
                '%entity%' => $this->entityName
            ]));
        }

        return $this->render('filiere/index.html.twig', [
            'filieres' => $filieres,
        ]);
    }

    #[Route('/new', name: 'app_filiere_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $filiere = new Filiere();
        $form = $this->createForm(FiliereType::class, $filiere);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $entityManager->persist($filiere);
                    $entityManager->flush();

                    $this->addSuccessFlash($this->translator->trans('flash.success.item_created', [
                        '%entity%' => $this->entityName . ' ' . $filiere->getNomFiliere()
                    ]));

                    return $this->redirectToRoute('app_filiere_index', [], Response::HTTP_SEE_OTHER);
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

        return $this->render('filiere/new.html.twig', [
            'filiere' => $filiere,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_filiere_show', methods: ['GET'])]
    public function show(?Filiere $filiere): Response
    {
        if (!$filiere) {
            $this->handleNotFoundException('filiere');
        }

        return $this->render('filiere/show.html.twig', [
            'filiere' => $filiere,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_filiere_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ?Filiere $filiere, EntityManagerInterface $entityManager): Response
    {
        if (!$filiere) {
            $this->handleNotFoundException('filiere');
        }

        $form = $this->createForm(FiliereType::class, $filiere);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $entityManager->flush();

                    $this->addSuccessFlash($this->translator->trans('flash.success.updated', [
                        '%entity%' => $this->translator->trans('entity.filiere')
                    ]));

                    return $this->redirectToRoute('app_filiere_index', [], Response::HTTP_SEE_OTHER);
                } catch (\Exception $e) {
                    $this->addErrorFlash($this->translator->trans('flash.error.update_error', [
                        '%entity%' => $this->translator->trans('entity.filiere')
                    ]));
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

        return $this->render('filiere/edit.html.twig', [
            'filiere' => $filiere,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_filiere_delete', methods: ['POST'])]
    public function delete(Request $request, ?Filiere $filiere, EntityManagerInterface $entityManager): Response
    {
        if (!$filiere) {
            $this->handleNotFoundException('filiere');
        }

        try {
            if ($this->isCsrfTokenValid('delete'.$filiere->getId(), $request->request->get('_token'))) {
                $entityManager->remove($filiere);
                $entityManager->flush();

                $this->addSuccessFlash($this->translator->trans('flash.success.deleted', [
                    '%entity%' => $this->translator->trans('entity.filiere')
                ]));
            }
        } catch (\Exception $e) {
            $this->addErrorFlash($this->translator->trans('flash.error.delete_error', [
                '%entity%' => $this->translator->trans('entity.filiere')
            ]));
        }

        return $this->redirectToRoute('app_filiere_index', [], Response::HTTP_SEE_OTHER);
    }
}
