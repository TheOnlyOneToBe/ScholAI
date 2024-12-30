<?php

namespace App\Service;

use App\Entity\Note;
use Doctrine\ORM\EntityManagerInterface;

class NoteService extends AbstractService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Note::class);
    }

    public function findByEtudiantAndEvaluation(int $etudiantId, int $evaluationId): ?Note
    {
        return $this->repository->findOneBy([
            'etudiant' => $etudiantId,
            'evaluation' => $evaluationId
        ]);
    }

    public function findByEtudiantAndMatiere(int $etudiantId, int $matiereId): array
    {
        return $this->repository->createQueryBuilder('n')
            ->join('n.evaluation', 'e')
            ->join('e.programme', 'p')
            ->where('n.etudiant = :etudiantId')
            ->andWhere('p.matiere = :matiereId')
            ->setParameter('etudiantId', $etudiantId)
            ->setParameter('matiereId', $matiereId)
            ->getQuery()
            ->getResult();
    }

    public function calculateMoyenne(int $etudiantId, int $matiereId): ?float
    {
        $notes = $this->findByEtudiantAndMatiere($etudiantId, $matiereId);
        if (empty($notes)) {
            return null;
        }

        $sum = 0;
        $coefficientSum = 0;
        foreach ($notes as $note) {
            $coefficient = $note->getEvaluation()->getCoefficient();
            $sum += $note->getValeur() * $coefficient;
            $coefficientSum += $coefficient;
        }

        return $coefficientSum > 0 ? $sum / $coefficientSum : null;
    }
}
