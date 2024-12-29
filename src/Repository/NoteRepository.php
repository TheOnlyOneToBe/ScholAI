<?php

namespace App\Repository;

use App\Entity\Note;
use App\Entity\Etudiant;
use App\Entity\Evaluation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Note>
 *
 * @method Note|null find($id, $lockMode = null, $lockVersion = null)
 * @method Note|null findOneBy(array $criteria, array $orderBy = null)
 * @method Note[]    findAll()
 * @method Note[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Note::class);
    }

    /**
     * Récupère la moyenne d'un étudiant
     */
    public function getMoyenneEtudiant(Etudiant $etudiant): float
    {
        $result = $this->createQueryBuilder('n')
            ->select('AVG(n.valeur) as moyenne')
            ->where('n.etudiant = :etudiant')
            ->setParameter('etudiant', $etudiant)
            ->getQuery()
            ->getSingleScalarResult();

        return $result ? round($result, 2) : 0;
    }

    /**
     * Récupère la moyenne d'une évaluation
     */
    public function getMoyenneEvaluation(Evaluation $evaluation): float
    {
        $result = $this->createQueryBuilder('n')
            ->select('AVG(n.valeur) as moyenne')
            ->where('n.evaluation = :evaluation')
            ->setParameter('evaluation', $evaluation)
            ->getQuery()
            ->getSingleScalarResult();

        return $result ? round($result, 2) : 0;
    }

    /**
     * Récupère les statistiques d'une évaluation
     */
    public function getEvaluationStats(Evaluation $evaluation): array
    {
        $qb = $this->createQueryBuilder('n')
            ->select('COUNT(n.id) as total')
            ->addSelect('SUM(CASE WHEN n.valeur >= 10 THEN 1 ELSE 0 END) as reussis')
            ->addSelect('MIN(n.valeur) as min')
            ->addSelect('MAX(n.valeur) as max')
            ->addSelect('AVG(n.valeur) as moyenne')
            ->where('n.evaluation = :evaluation')
            ->setParameter('evaluation', $evaluation);

        $result = $qb->getQuery()->getOneOrNullResult();

        return [
            'total' => $result['total'] ?? 0,
            'reussis' => $result['reussis'] ?? 0,
            'min' => $result['min'] ? round($result['min'], 2) : 0,
            'max' => $result['max'] ? round($result['max'], 2) : 0,
            'moyenne' => $result['moyenne'] ? round($result['moyenne'], 2) : 0,
            'taux_reussite' => $result['total'] ? round(($result['reussis'] / $result['total']) * 100, 2) : 0,
        ];
    }

    /**
     * Récupère les dernières notes avec les relations
     */
    public function findLatestWithRelations(int $limit = 5): array
    {
        return $this->createQueryBuilder('n')
            ->select('n, e, et, p')
            ->leftJoin('n.evaluation', 'e')
            ->leftJoin('n.etudiant', 'et')
            ->leftJoin('e.programme', 'p')
            ->orderBy('n.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupère les notes d'un étudiant par semestre
     */
    public function findByEtudiantAndSemestre(Etudiant $etudiant, int $semestre): array
    {
        return $this->createQueryBuilder('n')
            ->select('n, e, p')
            ->leftJoin('n.evaluation', 'e')
            ->leftJoin('e.programme', 'p')
            ->where('n.etudiant = :etudiant')
            ->andWhere('e.semestre = :semestre')
            ->setParameter('etudiant', $etudiant)
            ->setParameter('semestre', $semestre)
            ->orderBy('e.dateEvaluation', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Recherche les notes par critères
     */
    public function searchByCriteria(array $criteria): QueryBuilder
    {
        $qb = $this->createQueryBuilder('n')
            ->select('n, e, et')
            ->leftJoin('n.evaluation', 'e')
            ->leftJoin('n.etudiant', 'et');

        if (!empty($criteria['evaluation'])) {
            $qb->andWhere('n.evaluation = :evaluation')
               ->setParameter('evaluation', $criteria['evaluation']);
        }

        if (!empty($criteria['etudiant'])) {
            $qb->andWhere('n.etudiant = :etudiant')
               ->setParameter('etudiant', $criteria['etudiant']);
        }

        if (isset($criteria['valeur_min'])) {
            $qb->andWhere('n.valeur >= :valeur_min')
               ->setParameter('valeur_min', $criteria['valeur_min']);
        }

        if (isset($criteria['valeur_max'])) {
            $qb->andWhere('n.valeur <= :valeur_max')
               ->setParameter('valeur_max', $criteria['valeur_max']);
        }

        if (!empty($criteria['date_debut'])) {
            $qb->andWhere('e.dateEvaluation >= :date_debut')
               ->setParameter('date_debut', $criteria['date_debut']);
        }

        if (!empty($criteria['date_fin'])) {
            $qb->andWhere('e.dateEvaluation <= :date_fin')
               ->setParameter('date_fin', $criteria['date_fin']);
        }

        // Tri par défaut
        $qb->orderBy('n.createdAt', 'DESC');

        return $qb;
    }

    public function save(Note $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Note $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
