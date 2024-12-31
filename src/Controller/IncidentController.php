<?php

namespace App\Controller;

use App\Entity\Incident;
use App\Form\IncidentType;
use App\Repository\IncidentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Trait\FlashMessageTrait;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/incident')]
final class IncidentController extends AbstractController
{
    use FlashMessageTrait;

    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    #[Route('/', name: 'app_incident_index', methods: ['GET'])]
    public function index(IncidentRepository $incidentRepository): Response
    {
        return $this->render('incident/index.html.twig', [
            'incidents' => $incidentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_incident_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $incident = new Incident();
        $form = $this->createForm(IncidentType::class, $incident);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->persist($incident);
                $entityManager->flush();

                $this->addSuccessFlash(
                    $this->translator->trans('flash.success.created', [
                        '%entity%' => $this->translator->trans('incident.title')
                    ])
                );

                return $this->redirectToRoute('app_incident_index', [], Response::HTTP_SEE_OTHER);
            } catch (\Exception $e) {
                $this->addErrorFlash(
                    $this->translator->trans('flash.error.create_failed', [
                        '%entity%' => $this->translator->trans('incident.title')
                    ])
                );
            }
        }

        return $this->render('incident/new.html.twig', [
            'incident' => $incident,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_incident_show', methods: ['GET'])]
    public function show(Incident $incident): Response
    {
        return $this->render('incident/show.html.twig', [
            'incident' => $incident,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_incident_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Incident $incident, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(IncidentType::class, $incident);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->flush();

                $this->addSuccessFlash(
                    $this->translator->trans('flash.success.updated', [
                        '%entity%' => $this->translator->trans('incident.title')
                    ])
                );

                return $this->redirectToRoute('app_incident_index', [], Response::HTTP_SEE_OTHER);
            } catch (\Exception $e) {
                $this->addErrorFlash(
                    $this->translator->trans('flash.error.update_failed', [
                        '%entity%' => $this->translator->trans('incident.title')
                    ])
                );
            }
        }

        return $this->render('incident/edit.html.twig', [
            'incident' => $incident,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_incident_delete', methods: ['POST'])]
    public function delete(Request $request, Incident $incident, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$incident->getId(), $request->getPayload()->getString('_token'))) {
            try {
                $entityManager->remove($incident);
                $entityManager->flush();

                $this->addSuccessFlash(
                    $this->translator->trans('flash.success.deleted', [
                        '%entity%' => $this->translator->trans('incident.title')
                    ])
                );
            } catch (\Exception $e) {
                $this->addErrorFlash(
                    $this->translator->trans('flash.error.delete_failed', [
                        '%entity%' => $this->translator->trans('incident.title')
                    ])
                );
            }
        }

        return $this->redirectToRoute('app_incident_index', [], Response::HTTP_SEE_OTHER);
    }
}
