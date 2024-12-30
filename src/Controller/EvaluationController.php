<?php

namespace App\Controller;

use App\Entity\Evaluation;
use App\Form\EvaluationType;
use App\Repository\EvaluationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/evaluation')]
class EvaluationController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TranslatorInterface $translator
    ) {
    }

    #[Route('/', name: 'app_evaluation_index', methods: ['GET'])]
    public function index(EvaluationRepository $evaluationRepository): Response
    {
        return $this->render('evaluation/index.html.twig', [
            'evaluations' => $evaluationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_evaluation_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $evaluation = new Evaluation();
        $form = $this->createForm(EvaluationType::class, $evaluation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->persist($evaluation);
                $this->entityManager->flush();

                $this->addFlash('success', $this->translator->trans('flash.success.create', [
                    '%entity%' => $this->translator->trans('entity.evaluation')
                ]));

                return $this->redirectToRoute('app_evaluation_index');
            } catch (\Exception $e) {
                $this->addFlash('error', $this->translator->trans('flash.error.create', [
                    '%entity%' => $this->translator->trans('entity.evaluation')
                ]));
            }
        } elseif ($form->isSubmitted()) {
            $this->addFlash('error', $this->translator->trans('flash.error.form'));
        }

        return $this->render('evaluation/new.html.twig', [
            'evaluation' => $evaluation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evaluation_show', methods: ['GET'])]
    public function show(Evaluation $evaluation): Response
    {
        return $this->render('evaluation/show.html.twig', [
            'evaluation' => $evaluation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_evaluation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evaluation $evaluation): Response
    {
        $form = $this->createForm(EvaluationType::class, $evaluation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->flush();

                $this->addFlash('success', $this->translator->trans('flash.success.update', [
                    '%entity%' => $this->translator->trans('entity.evaluation')
                ]));

                return $this->redirectToRoute('app_evaluation_index');
            } catch (\Exception $e) {
                $this->addFlash('error', $this->translator->trans('flash.error.update', [
                    '%entity%' => $this->translator->trans('entity.evaluation')
                ]));
            }
        } elseif ($form->isSubmitted()) {
            $this->addFlash('error', $this->translator->trans('flash.error.form'));
        }

        return $this->render('evaluation/edit.html.twig', [
            'evaluation' => $evaluation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evaluation_delete', methods: ['POST'])]
    public function delete(Request $request, Evaluation $evaluation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evaluation->getId(), $request->request->get('_token'))) {
            try {
                $this->entityManager->remove($evaluation);
                $this->entityManager->flush();

                $this->addFlash('success', $this->translator->trans('flash.success.delete', [
                    '%entity%' => $this->translator->trans('entity.evaluation')
                ]));
            } catch (\Exception $e) {
                $this->addFlash('error', $this->translator->trans('flash.error.delete', [
                    '%entity%' => $this->translator->trans('entity.evaluation')
                ]));
            }
        }

        return $this->redirectToRoute('app_evaluation_index');
    }
}
