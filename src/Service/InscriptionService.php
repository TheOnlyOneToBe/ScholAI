<?php

namespace App\Service;

use App\Entity\Inscription;
use Doctrine\ORM\EntityManagerInterface;

class InscriptionService extends AbstractService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Inscription::class);
    }

    public function findByAnneeAndFiliereCycle(int $anneeId, int $filiereCycleId): array
    {
        return $this->repository->createQueryBuilder('i')
            ->where('i.annee = :anneeId')
            ->andWhere('i.filiereCycle = :filiereCycleId')
            ->setParameter('anneeId', $anneeId)
            ->setParameter('filiereCycleId', $filiereCycleId)
            ->getQuery()
            ->getResult();
    }

    public function generateNumeroInscription(int $anneeId): string
    {
        $count = $this->repository->count(['annee' => $anneeId]) + 1;
        $year = date('Y');
        return sprintf('INS%s%04d', substr($year, -2), $count);
    }
}
