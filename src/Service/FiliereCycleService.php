<?php

namespace App\Service;

use App\Entity\FiliereCycle;
use Doctrine\ORM\EntityManagerInterface;

class FiliereCycleService extends AbstractService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, FiliereCycle::class);
    }

    public function findByFiliere(int $filiereId): array
    {
        return $this->repository->findBy(['filiere' => $filiereId]);
    }

    public function findByCycle(int $cycleId): array
    {
        return $this->repository->findBy(['cycle' => $cycleId]);
    }

    public function findActiveByFiliere(int $filiereId): array
    {
        return $this->repository->createQueryBuilder('fc')
            ->where('fc.filiere = :filiereId')
            ->andWhere('fc.isActive = :isActive')
            ->setParameter('filiereId', $filiereId)
            ->setParameter('isActive', true)
            ->getQuery()
            ->getResult();
    }

    public function getInscriptionsByFiliereCycle(int $filiereCycleId): array
    {
        return $this->repository->createQueryBuilder('fc')
            ->select('fc', 'i')
            ->leftJoin('fc.inscriptions', 'i')
            ->where('fc.id = :filiereCycleId')
            ->setParameter('filiereCycleId', $filiereCycleId)
            ->getQuery()
            ->getResult();
    }

    public function createFiliereCycle(int $filiereId, int $cycleId, bool $isActive = true): FiliereCycle
    {
        $filiereCycle = new FiliereCycle();
        $filiereCycle->setFiliere($this->entityManager->getReference('App\Entity\Filiere', $filiereId));
        $filiereCycle->setCycle($this->entityManager->getReference('App\Entity\Cycle', $cycleId));
        $filiereCycle->setIsActive($isActive);

        $this->save($filiereCycle);

        return $filiereCycle;
    }
}
