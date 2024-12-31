<?php

namespace App\Controller;

use App\Entity\ChefDepartement;
use App\Form\ChefDepartementType;
use App\Repository\ChefDepartementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Trait\FlashMessageTrait;
use App\Controller\Trait\ErrorHandlerTrait;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/chef/departement')]
class ChefDepartementController extends AbstractController
{
    use FlashMessageTrait;
    use ErrorHandlerTrait;

    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    #[Route('/', name: 'app_chef_departement_index', methods: ['GET'])]
    public function index(ChefDepartementRepository $chefDepartementRepository): Response
    {
        $chefDepartements = $chefDepartementRepository->findAll();
        
        if (empty($chefDepartements)) {
            $this->addInfoFlash($this->translator->trans('flash.info.no_records'));
        }

        return $this->render('chef_departement/index.html.twig', [
            'chef_departements' => $chefDepartements,
        ]);
    }

    #[Route('/new', name: 'app_chef_departement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        try {
            $chefDepartement = new ChefDepartement();
            $form = $this->createForm(ChefDepartementType::class, $chefDepartement);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($chefDepartement);
                $entityManager->flush();

                $this->addSuccessFlash($this->translator->trans('flash.success.created', [
                    '%entity%' => $this->translator->trans('entity.chef_departement')
                ]));

                return $this->redirectToRoute('app_chef_departement_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('chef_departement/new.html.twig', [
                'chef_departement' => $chefDepartement,
                'form' => $form,
            ]);
        } catch (\Exception $e) {
            $this->addErrorFlash($this->translator->trans('flash.error.create_error', [
                '%entity%' => $this->translator->trans('entity.chef_departement')
            ]));
            return $this->redirectToRoute('app_chef_departement_index');
        }
    }

    #[Route('/{id}', name: 'app_chef_departement_show', methods: ['GET'])]
    public function show(ChefDepartement $chefDepartement = null): Response
    {
        if (!$chefDepartement) {
            $this->handleNotFoundException('chef_departement');
        }

        return $this->render('chef_departement/show.html.twig', [
            'chef_departement' => $chefDepartement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_chef_departement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ChefDepartement $chefDepartement = null, EntityManagerInterface $entityManager): Response
    {
        if (!$chefDepartement) {
            $this->handleNotFoundException('chef_departement');
        }

        try {
            $form = $this->createForm(ChefDepartementType::class, $chefDepartement);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();

                $this->addSuccessFlash($this->translator->trans('flash.success.updated', [
                    '%entity%' => $this->translator->trans('entity.chef_departement')
                ]));

                return $this->redirectToRoute('app_chef_departement_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('chef_departement/edit.html.twig', [
                'chef_departement' => $chefDepartement,
                'form' => $form,
            ]);
        } catch (\Exception $e) {
            $this->addErrorFlash($this->translator->trans('flash.error.update_error', [
                '%entity%' => $this->translator->trans('entity.chef_departement')
            ]));
            return $this->redirectToRoute('app_chef_departement_index');
        }
    }

    #[Route('/{id}', name: 'app_chef_departement_delete', methods: ['POST'])]
    public function delete(Request $request, ChefDepartement $chefDepartement = null, EntityManagerInterface $entityManager): Response
    {
        if (!$chefDepartement) {
            $this->handleNotFoundException('chef_departement');
        }

        try {
            if ($this->isCsrfTokenValid('delete'.$chefDepartement->getId(), $request->request->get('_token'))) {
                $entityManager->remove($chefDepartement);
                $entityManager->flush();

                $this->addSuccessFlash($this->translator->trans('flash.success.deleted', [
                    '%entity%' => $this->translator->trans('entity.chef_departement')
                ]));
            }
        } catch (\Exception $e) {
            $this->addErrorFlash($this->translator->trans('flash.error.delete_error', [
                '%entity%' => $this->translator->trans('entity.chef_departement')
            ]));
        }

        return $this->redirectToRoute('app_chef_departement_index', [], Response::HTTP_SEE_OTHER);
    }
}
