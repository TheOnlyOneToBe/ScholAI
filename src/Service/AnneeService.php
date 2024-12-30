<?php

namespace App\Service;

use App\Entity\Annee;
use Doctrine\ORM\EntityManagerInterface;

class AnneeService extends AbstractService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Annee::class);
    }

    public function getCurrentAnnee(): ?Annee
    {
        return $this->repository->findOneBy(['yearStatut' => true]);
    }

    public function findByPeriod(\DateTime $start, \DateTime $end): array
    {
        return $this->repository->createQueryBuilder('a')
            ->where('a.year_start >= :start')
            ->andWhere('a.yearEnd <= :end')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->getQuery()
            ->getResult();
    }

    public function setCurrentAnnee(Annee $annee): void
    {
        // Désactiver l'année scolaire actuelle
        $currentAnnee = $this->getCurrentAnnee();
        if ($currentAnnee) {
            $currentAnnee->setYearStatut(false);
            $this->save($currentAnnee, false);
        }

        // Activer la nouvelle année scolaire
        $annee->setYearStatut(true);
        $this->save($annee);
    }

    public function getInscriptionsByAnnee(int $anneeId): array
    {
        return $this->repository->createQueryBuilder('a')
            ->select('a', 'i')
            ->leftJoin('a.inscriptions', 'i')
            ->where('a.id = :anneeId')
            ->setParameter('anneeId', $anneeId)
            ->getQuery()
            ->getResult();
    }

    public function getProgrammesByAnnee(int $anneeId): array
    {
        return $this->repository->createQueryBuilder('a')
            ->select('a', 'p')
            ->leftJoin('a.programmes', 'p')
            ->where('a.id = :anneeId')
            ->setParameter('anneeId', $anneeId)
            ->getQuery()
            ->getResult();
    }

    public function createNewAnnee(\DateTime $start, \DateTime $end, bool $isActive = false): Annee
    {
        $annee = new Annee();
        $annee->setYearStart($start);
        $annee->setYearEnd($end);
        $annee->setYearStatut($isActive);

        $this->save($annee);

        if ($isActive) {
            $this->setCurrentAnnee($annee);
        }

        return $annee;
    }
}
