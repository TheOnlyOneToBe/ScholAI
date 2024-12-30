<?php

namespace App\Service;

use App\Entity\Etudiant;
use Doctrine\ORM\EntityManagerInterface;

class EtudiantService extends AbstractService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Etudiant::class);
    }

    public function generateMatricule(): string
    {
        $year = date('Y');
        $count = $this->count() + 1;
        return sprintf('ETU%s%04d', substr($year, -2), $count);
    }

    public function findByFiliere(int $filiereId): array
    {
        return $this->repository->createQueryBuilder('e')
            ->join('e.inscriptions', 'i')
            ->join('i.filiereCycle', 'fc')
            ->join('fc.filiere', 'f')
            ->where('f.id = :filiereId')
            ->setParameter('filiereId', $filiereId)
            ->getQuery()
            ->getResult();
    }

    public function findByCycle(int $cycleId): array
    {
        return $this->repository->createQueryBuilder('e')
            ->join('e.inscriptions', 'i')
            ->join('i.filiereCycle', 'fc')
            ->join('fc.cycle', 'c')
            ->where('c.id = :cycleId')
            ->setParameter('cycleId', $cycleId)
            ->getQuery()
            ->getResult();
    }

    public function findByAnnee(int $anneeId): array
    {
        return $this->repository->createQueryBuilder('e')
            ->join('e.inscriptions', 'i')
            ->join('i.annee', 'a')
            ->where('a.id = :anneeId')
            ->setParameter('anneeId', $anneeId)
            ->getQuery()
            ->getResult();
    }
}
