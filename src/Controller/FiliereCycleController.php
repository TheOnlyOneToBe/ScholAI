<?php

namespace App\Controller;

use App\Entity\FiliereCycle;
use App\Form\FiliereCycleType;
use App\Repository\FiliereCycleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/filiere-cycle')]
class FiliereCycleController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator
    ) {
    }

    #[Route('/', name: 'app_filiere_cycle_index', methods: ['GET'])]
    public function index(FiliereCycleRepository $filiereCycleRepository): Response
    {
        return $this->render('filiere_cycle/index.html.twig', [
            'filiere_cycles' => $filiereCycleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_filiere_cycle_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $filiereCycle = new FiliereCycle();
        $form = $this->createForm(FiliereCycleType::class, $filiereCycle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->persist($filiereCycle);
                $this->entityManager->flush();

                $this->addFlash('success', $this->translator->trans('flash.success.create', [
                    '%entity%' => $this->translator->trans('entity.filiere_cycle')
                ]));

                return $this->redirectToRoute('app_filiere_cycle_index');
            } catch (\Exception $e) {
                $this->addFlash('error', $this->translator->trans('flash.error.create', [
                    '%entity%' => $this->translator->trans('entity.filiere_cycle')
                ]));
            }
        } elseif ($form->isSubmitted()) {
            $this->addFlash('error', $this->translator->trans('flash.error.form'));
        }

        return $this->render('filiere_cycle/new.html.twig', [
            'filiere_cycle' => $filiereCycle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_filiere_cycle_show', methods: ['GET'])]
    public function show(FiliereCycle $filiereCycle): Response
    {
        return $this->render('filiere_cycle/show.html.twig', [
            'filiere_cycle' => $filiereCycle,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_filiere_cycle_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FiliereCycle $filiereCycle): Response
    {
        $form = $this->createForm(FiliereCycleType::class, $filiereCycle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->flush();

                $this->addFlash('success', $this->translator->trans('flash.success.update', [
                    '%entity%' => $this->translator->trans('entity.filiere_cycle')
                ]));

                return $this->redirectToRoute('app_filiere_cycle_index');
            } catch (\Exception $e) {
                $this->addFlash('error', $this->translator->trans('flash.error.update', [
                    '%entity%' => $this->translator->trans('entity.filiere_cycle')
                ]));
            }
        } elseif ($form->isSubmitted()) {
            $this->addFlash('error', $this->translator->trans('flash.error.form'));
        }

        return $this->render('filiere_cycle/edit.html.twig', [
            'filiere_cycle' => $filiereCycle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_filiere_cycle_delete', methods: ['POST'])]
    public function delete(Request $request, FiliereCycle $filiereCycle): Response
    {
        if ($this->isCsrfTokenValid('delete'.$filiereCycle->getId(), $request->request->get('_token'))) {
            try {
                $this->entityManager->remove($filiereCycle);
                $this->entityManager->flush();

                $this->addFlash('success', $this->translator->trans('flash.success.delete', [
                    '%entity%' => $this->translator->trans('entity.filiere_cycle')
                ]));
            } catch (\Exception $e) {
                $this->addFlash('error', $this->translator->trans('flash.error.delete', [
                    '%entity%' => $this->translator->trans('entity.filiere_cycle')
                ]));
            }
        }

        return $this->redirectToRoute('app_filiere_cycle_index');
    }
}
