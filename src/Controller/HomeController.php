<?php

namespace App\Controller;

use App\Repository\EtudiantRepository;
use App\Repository\ProfesseurRepository;
use App\Repository\EvaluationRepository;
use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        EtudiantRepository $etudiantRepository,
        ProfesseurRepository $professeurRepository,
        EvaluationRepository $evaluationRepository,
        NoteRepository $noteRepository
    ): Response {
        // Récupérer les statistiques
        $stats = [
            'students' => $etudiantRepository->count([]),
            'teachers' => $professeurRepository->count([]),
            'evaluations' => $evaluationRepository->count([]),
            'notes' => $noteRepository->count([])
        ];

        // Récupérer les 5 dernières notes
        $dernieresNotes = $noteRepository->findBy([], ['id' => 'DESC'], 5);

        // Récupérer les 5 prochaines évaluations
        $prochainEvaluations = $evaluationRepository->findBy(
            ['dateEvaluation' => new \DateTime()],
            ['dateEvaluation' => 'ASC'],
            5
        );

        return $this->render('home/index.html.twig', [
            'stats' => $stats,
            'dernieresNotes' => $dernieresNotes,
            'prochainEvaluations' => $prochainEvaluations,
        ]);
    }
}
