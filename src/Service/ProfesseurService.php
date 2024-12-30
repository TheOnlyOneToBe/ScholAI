<?php

namespace App\Service;

use App\Entity\Professeur;
use Doctrine\ORM\EntityManagerInterface;

class ProfesseurService extends AbstractService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Professeur::class);
    }

    public function findByDepartement(int $departementId): array
    {
        return $this->repository->findBy(['departement' => $departementId]);
    }

    public function findByMatiere(int $matiereId): array
    {
        return $this->repository->createQueryBuilder('p')
            ->join('p.programmes', 'prog')
            ->join('prog.matiere', 'm')
            ->where('m.id = :matiereId')
            ->setParameter('matiereId', $matiereId)
            ->getQuery()
            ->getResult();
    }
}
