<?php

namespace App\Controller;

use App\Entity\Bourse;
use App\Form\BourseType;
use App\Repository\BourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Trait\FlashMessageTrait;
use App\Controller\Trait\ErrorHandlerTrait;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/bourse')]
class BourseController extends AbstractController
{
    use FlashMessageTrait;
    use ErrorHandlerTrait;

    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    #[Route('/', name: 'app_bourse_index', methods: ['GET'])]
    public function index(BourseRepository $bourseRepository): Response
    {
        $bourses = $bourseRepository->findAll();
        
        if (empty($bourses)) {
            $this->addInfoFlash($this->translator->trans('flash.info.no_records'));
        }

        return $this->render('bourse/index.html.twig', [
            'bourses' => $bourses,
        ]);
    }

    #[Route('/new', name: 'app_bourse_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        try {
            $bourse = new Bourse();
            $form = $this->createForm(BourseType::class, $bourse);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($bourse);
                $entityManager->flush();

                $this->addSuccessFlash($this->translator->trans('flash.success.created', [
                    '%entity%' => $this->translator->trans('entity.bourse')
                ]));

                return $this->redirectToRoute('app_bourse_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('bourse/new.html.twig', [
                'bourse' => $bourse,
                'form' => $form,
            ]);
        } catch (\Exception $e) {
            $this->addErrorFlash($this->translator->trans('flash.error.create_error', [
                '%entity%' => $this->translator->trans('entity.bourse')
            ]));
            return $this->redirectToRoute('app_bourse_index');
        }
    }

    #[Route('/{id}', name: 'app_bourse_show', methods: ['GET'])]
    public function show(Bourse $bourse = null): Response
    {
        if (!$bourse) {
            $this->handleNotFoundException('bourse');
        }

        return $this->render('bourse/show.html.twig', [
            'bourse' => $bourse,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bourse_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bourse $bourse = null, EntityManagerInterface $entityManager): Response
    {
        if (!$bourse) {
            $this->handleNotFoundException('bourse');
        }

        try {
            $form = $this->createForm(BourseType::class, $bourse);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();

                $this->addSuccessFlash($this->translator->trans('flash.success.updated', [
                    '%entity%' => $this->translator->trans('entity.bourse')
                ]));

                return $this->redirectToRoute('app_bourse_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('bourse/edit.html.twig', [
                'bourse' => $bourse,
                'form' => $form,
            ]);
        } catch (\Exception $e) {
            $this->addErrorFlash($this->translator->trans('flash.error.update_error', [
                '%entity%' => $this->translator->trans('entity.bourse')
            ]));
            return $this->redirectToRoute('app_bourse_index');
        }
    }

    #[Route('/{id}', name: 'app_bourse_delete', methods: ['POST'])]
    public function delete(Request $request, Bourse $bourse = null, EntityManagerInterface $entityManager): Response
    {
        if (!$bourse) {
            $this->handleNotFoundException('bourse');
        }

        try {
            if ($this->isCsrfTokenValid('delete'.$bourse->getId(), $request->request->get('_token'))) {
                $entityManager->remove($bourse);
                $entityManager->flush();

                $this->addSuccessFlash($this->translator->trans('flash.success.deleted', [
                    '%entity%' => $this->translator->trans('entity.bourse')
                ]));
            }
        } catch (\Exception $e) {
            $this->addErrorFlash($this->translator->trans('flash.error.delete_error', [
                '%entity%' => $this->translator->trans('entity.bourse')
            ]));
        }

        return $this->redirectToRoute('app_bourse_index', [], Response::HTTP_SEE_OTHER);
    }
}
