<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use App\Repository\CoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Trait\FlashMessageTrait;
use App\Controller\Trait\ErrorHandlerTrait;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

#[Route('/cours')]
class CoursController extends AbstractController
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

    #[Route('/', name: 'app_cours_index', methods: ['GET'])]
    public function index(CoursRepository $coursRepository): Response
    {
        $cours = $coursRepository->findAll();
        
        if (empty($cours)) {
            $this->addInfoFlash($this->translator->trans('flash.info.no_records'));
        }

        return $this->render('cours/index.html.twig', [
            'cours' => $cours,
        ]);
    }

    #[Route('/new', name: 'app_cours_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

            $cours = new Cours();
            $form = $this->createForm(CoursType::class, $cours);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                try {
                $entityManager->persist($cours);
                $entityManager->flush();

                $this->addSuccessFlash($this->translator->trans('flash.success.created', [
                    '%entity%' => $this->translator->trans('entity.cours')
                ]));

                return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
            }
                catch (\Exception $e) {
                    $this->addErrorFlash($this->translator->trans('flash.error.create_error', [
                        '%entity%' => $this->translator->trans('entity.cours')
                    ]));
                    return $this->redirectToRoute('app_cours_index');
                }
             }

            return $this->render('cours/new.html.twig', [
                'cour' => $cours,
                'form' => $form,
            ]);

    }

    #[Route('/{id}', name: 'app_cours_show', methods: ['GET'])]
    public function show(Cours $cours): Response
    {
        if (!$cours) {
            $this->handleNotFoundException('cours');
        }

        return $this->render('cours/show.html.twig', [
            'cour' => $cours,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cours_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cours $cours = null, EntityManagerInterface $entityManager): Response
    {
        if (!$cours) {
            $this->handleNotFoundException('cours');
        }

        try {
            $form = $this->createForm(CoursType::class, $cours);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();

                $this->addSuccessFlash($this->translator->trans('flash.success.updated', [
                    '%entity%' => $this->translator->trans('entity.cours')
                ]));

                return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('cours/edit.html.twig', [
                'cours' => $cours,
                'form' => $form,
            ]);
        } catch (\Exception $e) {
            $this->addErrorFlash($this->translator->trans('flash.error.update_error', [
                '%entity%' => $this->translator->trans('entity.cours')
            ]));
            return $this->redirectToRoute('app_cours_index');
        }
    }

    #[Route('/{id}', name: 'app_cours_delete', methods: ['POST'])]
    public function delete(Request $request, Cours $cours = null, EntityManagerInterface $entityManager): Response
    {
        if (!$cours) {
            $this->handleNotFoundException('cours');
        }

        try {
            if ($this->isCsrfTokenValid('delete'.$cours->getId(), $request->request->get('_token'))) {
                $entityManager->remove($cours);
                $entityManager->flush();

                $this->addSuccessFlash($this->translator->trans('flash.success.deleted', [
                    '%entity%' => $this->translator->trans('entity.cours')
                ]));
            }
        } catch (\Exception $e) {
            $this->addErrorFlash($this->translator->trans('flash.error.delete_error', [
                '%entity%' => $this->translator->trans('entity.cours')
            ]));
        }

        return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
    }
}
