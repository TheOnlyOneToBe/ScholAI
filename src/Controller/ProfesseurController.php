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
use App\Controller\Trait\FlashMessageTrait;
use App\Controller\Trait\ErrorHandlerTrait;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/professeur')]
class ProfesseurController extends AbstractController
{
    use FlashMessageTrait;
    use ErrorHandlerTrait;

    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    #[Route('/', name: 'app_professeur_index', methods: ['GET'])]
    public function index(ProfesseurRepository $professeurRepository): Response
    {
        $professeurs = $professeurRepository->findAll();
        
        if (empty($professeurs)) {
            $this->addInfoFlash($this->translator->trans('flash.info.no_records'));
        }

        return $this->render('professeur/index.html.twig', [
            'professeurs' => $professeurs,
        ]);
    }

    #[Route('/new', name: 'app_professeur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        try {
            $professeur = new Professeur();
            $form = $this->createForm(ProfesseurType::class, $professeur);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($professeur);
                $entityManager->flush();

                $this->addSuccessFlash($this->translator->trans('flash.success.created', [
                    '%entity%' => $this->translator->trans('entity.professeur')
                ]));

                return $this->redirectToRoute('app_professeur_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('professeur/new.html.twig', [
                'professeur' => $professeur,
                'form' => $form,
            ]);
        } catch (\Exception $e) {
            $this->addErrorFlash($this->translator->trans('flash.error.create_error', [
                '%entity%' => $this->translator->trans('entity.professeur')
            ]));
            return $this->redirectToRoute('app_professeur_index');
        }
    }

    #[Route('/{id}', name: 'app_professeur_show', methods: ['GET'])]
    public function show(Professeur $professeur = null): Response
    {
        if (!$professeur) {
            $this->handleNotFoundException('professeur');
        }

        return $this->render('professeur/show.html.twig', [
            'professeur' => $professeur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_professeur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Professeur $professeur = null, EntityManagerInterface $entityManager): Response
    {
        if (!$professeur) {
            $this->handleNotFoundException('professeur');
        }

        try {
            $form = $this->createForm(ProfesseurType::class, $professeur);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();

                $this->addSuccessFlash($this->translator->trans('flash.success.updated', [
                    '%entity%' => $this->translator->trans('entity.professeur')
                ]));

                return $this->redirectToRoute('app_professeur_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('professeur/edit.html.twig', [
                'professeur' => $professeur,
                'form' => $form,
            ]);
        } catch (\Exception $e) {
            $this->addErrorFlash($this->translator->trans('flash.error.update_error', [
                '%entity%' => $this->translator->trans('entity.professeur')
            ]));
            return $this->redirectToRoute('app_professeur_index');
        }
    }

    #[Route('/{id}', name: 'app_professeur_delete', methods: ['POST'])]
    public function delete(Request $request, Professeur $professeur = null, EntityManagerInterface $entityManager): Response
    {
        if (!$professeur) {
            $this->handleNotFoundException('professeur');
        }

        try {
            if ($this->isCsrfTokenValid('delete'.$professeur->getId(), $request->request->get('_token'))) {
                $entityManager->remove($professeur);
                $entityManager->flush();

                $this->addSuccessFlash($this->translator->trans('flash.success.deleted', [
                    '%entity%' => $this->translator->trans('entity.professeur')
                ]));
            }
        } catch (\Exception $e) {
            $this->addErrorFlash($this->translator->trans('flash.error.delete_error', [
                '%entity%' => $this->translator->trans('entity.professeur')
            ]));
        }

        return $this->redirectToRoute('app_professeur_index', [], Response::HTTP_SEE_OTHER);
    }
}
