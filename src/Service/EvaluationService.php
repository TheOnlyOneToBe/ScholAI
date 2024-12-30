<?php

namespace App\Service;

use App\Entity\Evaluation;
use Doctrine\ORM\EntityManagerInterface;

class EvaluationService extends AbstractService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Evaluation::class);
    }

    public function findByProgramme(int $programmeId): array
    {
        return $this->repository->findBy(['programme' => $programmeId]);
    }

    public function findBySemestre(int $semestreId): array
    {
        return $this->repository->createQueryBuilder('e')
            ->join('e.programme', 'p')
            ->where('p.semestre = :semestreId')
            ->setParameter('semestreId', $semestreId)
            ->getQuery()
            ->getResult();
    }

    public function findByMatiere(int $matiereId): array
    {
        return $this->repository->createQueryBuilder('e')
            ->join('e.programme', 'p')
            ->where('p.matiere = :matiereId')
            ->setParameter('matiereId', $matiereId)
            ->getQuery()
            ->getResult();
    }
}
