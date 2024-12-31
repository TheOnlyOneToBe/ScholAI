<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Form\CampusType;
use App\Repository\CampusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Trait\FlashMessageTrait;
use App\Controller\Trait\ErrorHandlerTrait;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/campus')]
class CampusController extends AbstractController
{
    use FlashMessageTrait;
    use ErrorHandlerTrait;

    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    #[Route('/', name: 'app_campus_index', methods: ['GET'])]
    public function index(CampusRepository $campusRepository): Response
    {
        $campuses = $campusRepository->findAll();
        
        if (empty($campuses)) {
            $this->addInfoFlash($this->translator->trans('flash.info.no_records'));
        }

        return $this->render('campus/index.html.twig', [
            'campuses' => $campuses,
        ]);
    }

    #[Route('/new', name: 'app_campus_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        try {
            $campus = new Campus();
            $form = $this->createForm(CampusType::class, $campus);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($campus);
                $entityManager->flush();

                $this->addSuccessFlash($this->translator->trans('flash.success.created', [
                    '%entity%' => $this->translator->trans('entity.campus')
                ]));

                return $this->redirectToRoute('app_campus_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('campus/new.html.twig', [
                'campus' => $campus,
                'form' => $form,
            ]);
        } catch (\Exception $e) {
            $this->addErrorFlash($this->translator->trans('flash.error.create_error', [
                '%entity%' => $this->translator->trans('entity.campus')
            ]));
            return $this->redirectToRoute('app_campus_index');
        }
    }

    #[Route('/{id}', name: 'app_campus_show', methods: ['GET'])]
    public function show(Campus $campus = null): Response
    {
        if (!$campus) {
            $this->handleNotFoundException('campus');
        }

        return $this->render('campus/show.html.twig', [
            'campus' => $campus,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_campus_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Campus $campus = null, EntityManagerInterface $entityManager): Response
    {
        if (!$campus) {
            $this->handleNotFoundException('campus');
        }

        try {
            $form = $this->createForm(CampusType::class, $campus);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();

                $this->addSuccessFlash($this->translator->trans('flash.success.updated', [
                    '%entity%' => $this->translator->trans('entity.campus')
                ]));

                return $this->redirectToRoute('app_campus_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('campus/edit.html.twig', [
                'campus' => $campus,
                'form' => $form,
            ]);
        } catch (\Exception $e) {
            $this->addErrorFlash($this->translator->trans('flash.error.update_error', [
                '%entity%' => $this->translator->trans('entity.campus')
            ]));
            return $this->redirectToRoute('app_campus_index');
        }
    }

    #[Route('/{id}', name: 'app_campus_delete', methods: ['POST'])]
    public function delete(Request $request, Campus $campus = null, EntityManagerInterface $entityManager): Response
    {
        if (!$campus) {
            $this->handleNotFoundException('campus');
        }

        try {
            if ($this->isCsrfTokenValid('delete'.$campus->getId(), $request->request->get('_token'))) {
                $entityManager->remove($campus);
                $entityManager->flush();

                $this->addSuccessFlash($this->translator->trans('flash.success.deleted', [
                    '%entity%' => $this->translator->trans('entity.campus')
                ]));
            }
        } catch (\Exception $e) {
            $this->addErrorFlash($this->translator->trans('flash.error.delete_error', [
                '%entity%' => $this->translator->trans('entity.campus')
            ]));
        }

        return $this->redirectToRoute('app_campus_index', [], Response::HTTP_SEE_OTHER);
    }
}
