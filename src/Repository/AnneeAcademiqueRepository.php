<?php

namespace App\Repository;

use App\Entity\AnneeAcademique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnneeAcademique>
 *
 * @method AnneeAcademique|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnneeAcademique|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnneeAcademique[]    findAll()
 * @method AnneeAcademique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnneeAcademiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnneeAcademique::class);
    }

    public function removeCurrentFlag(?int $exceptId = null): void
    {
        $qb = $this->createQueryBuilder('a')
            ->update()
            ->set('a.current', ':current')
            ->setParameter('current', false);

        if ($exceptId !== null) {
            $qb->where('a.id != :exceptId')
               ->setParameter('exceptId', $exceptId);
        }

        $qb->getQuery()->execute();
    }

    /**
     * Trouve l'année académique courante
     */
    public function findCurrent(): ?AnneeAcademique
    {
        return $this->findOneBy(['current' => true]);
    }
}
