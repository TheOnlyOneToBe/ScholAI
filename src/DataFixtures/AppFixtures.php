<?php

namespace App\DataFixtures;

use App\Entity\Annee;
use App\Entity\Campus;
use App\Entity\Cycle;
use App\Entity\Departement;
use App\Entity\Etudiant;
use App\Entity\Evaluation;
use App\Entity\Filiere;
use App\Entity\FiliereCycle;
use App\Entity\Matiere;
use App\Entity\Note;
use App\Entity\Professeur;
use App\Entity\Programme;
use App\Entity\Semestre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Année académique (une seule active)
        $annee = new Annee();
        $annee->setLibelle('2023-2024')
              ->setDateDebut(new \DateTime('2023-09-04'))
              ->setDateFin(new \DateTime('2024-07-31'))
              ->setStatut(true);
        $manager->persist($annee);

        // Campus
        $campus = new Campus();
        $campus->setLibelle('Campus Principal de Yaoundé')
               ->setAdresse('Quartier Ngoa-Ekelle, Yaoundé')
               ->setTelephone('+237 222 234 567')
               ->setEmail('contact@campus-yaounde.cm');
        $manager->persist($campus);

        // Départements
        $departements = [];
        $depNames = [
            'Génie Informatique',
            'Génie Civil',
            'Gestion et Commerce',
            'Sciences de l\'Ingénieur'
        ];

        foreach ($depNames as $name) {
            $dep = new Departement();
            $dep->setLibelle($name);
            $manager->persist($dep);
            $departements[] = $dep;
        }

        // Cycles
        $cycles = [];
        $cycleNames = ['Licence', 'Master'];
        foreach ($cycleNames as $name) {
            $cycle = new Cycle();
            $cycle->setLibelle($name);
            $manager->persist($cycle);
            $cycles[] = $cycle;
        }

        // Filières
        $filieres = [];
        $filiereData = [
            'Génie Logiciel' => $departements[0],
            'Réseaux et Télécommunications' => $departements[0],
            'Génie Civil' => $departements[1],
            'Commerce International' => $departements[2],
            'Génie Mécanique' => $departements[3]
        ];

        foreach ($filiereData as $name => $dep) {
            $filiere = new Filiere();
            $filiere->setLibelle($name);
            $manager->persist($filiere);
            $filieres[] = $filiere;
        }

        // FiliereCycles
        $filiereCycles = [];
        foreach ($filieres as $filiere) {
            foreach ($cycles as $cycle) {
                $filiereCycle = new FiliereCycle();
                $filiereCycle->setFiliere($filiere)
                            ->setCycle($cycle);
                $manager->persist($filiereCycle);
                $filiereCycles[] = $filiereCycle;
            }
        }

        // Semestres
        $semestres = [];
        $semestreNames = ['Semestre 1', 'Semestre 2'];
        foreach ($semestreNames as $name) {
            $semestre = new Semestre();
            $semestre->setLibelle($name);
            $manager->persist($semestre);
            $semestres[] = $semestre;
        }

        // Professeurs
        $professeurs = [];
        $profData = [
            ['Dr. KAMGA Paul', 'M', '+237 655123456'],
            ['Dr. NGANOU Marie', 'F', '+237 655789012'],
            ['Prof. MBARGA Jean', 'M', '+237 655345678'],
            ['Dr. FOUDA Claire', 'F', '+237 655901234']
        ];

        foreach ($profData as [$name, $sexe, $tel]) {
            $prof = new Professeur();
            $prof->setNoms($name)
                 ->setSexeProfesseur($sexe)
                 ->setTelephone($tel);
            $manager->persist($prof);
            $professeurs[] = $prof;
        }

        // Matières
        $matieres = [];
        $matiereData = [
            'Programmation Java' => 'INF201',
            'Base de données' => 'INF202',
            'Réseaux informatiques' => 'INF203',
            'Analyse numérique' => 'MAT201',
            'Anglais technique' => 'ANG201'
        ];

        foreach ($matiereData as $name => $code) {
            $matiere = new Matiere();
            $matiere->setLibelle($name)
                   ->setCode($code);
            $manager->persist($matiere);
            $matieres[] = $matiere;
        }

        // Programmes
        $programmes = [];
        foreach ($matieres as $index => $matiere) {
            $programme = new Programme();
            $programme->setMatiere($matiere)
                     ->setProfesseur($professeurs[$index % count($professeurs)])
                     ->setFiliereCycle($filiereCycles[0])
                     ->setAnnee($annee)
                     ->setSemestre($semestres[0])
                     ->setHeurealloue(30);
            $manager->persist($programme);
            $programmes[] = $programme;
        }

        // Étudiants
        $etudiants = [];
        $etudiantData = [
            ['TCHAMBA Kevin', 'TCHAMBA', 'Kevin', 'M', '2023GL001'],
            ['FOUDA Sarah', 'FOUDA', 'Sarah', 'F', '2023GL002'],
            ['ATANGANA Paul', 'ATANGANA', 'Paul', 'M', '2023GL003'],
            ['MENGUE Alice', 'MENGUE', 'Alice', 'F', '2023GL004']
        ];

        foreach ($etudiantData as [$fullName, $nom, $prenom, $sexe, $matricule]) {
            $etudiant = new Etudiant();
            $etudiant->setNoms($nom)
                    ->setPrenoms($prenom)
                    ->setAge(rand(18, 25))
                    ->setSexeEtudiant($sexe)
                    ->setMatriculeStudent($matricule)
                    ->setStudentFather($fullName . ' Père')
                    ->setStudentMother($fullName . ' Mère')
                    ->setTelephone('+237 6' . rand(55000000, 99999999));
            $manager->persist($etudiant);
            $etudiants[] = $etudiant;
        }

        // Évaluations
        $evaluations = [];
        $evaluationTypes = ['cc', 'examen', 'tp'];
        foreach ($programmes as $programme) {
            foreach ($evaluationTypes as $type) {
                $evaluation = new Evaluation();
                $evaluation->setTitre($type . ' - ' . $programme->getMatiere()->getLibelle())
                          ->setDescription('Évaluation de type ' . strtoupper($type))
                          ->setDateEvaluation(new \DateTime('+2 weeks'))
                          ->setProgramme($programme)
                          ->setSemestre($programme->getSemestre())
                          ->setType($type)
                          ->setCoefficient($type === 'examen' ? 0.6 : 0.2)
                          ->setCreatedBy('admin')
                          ->setCreatedAt(new \DateTime());
                $manager->persist($evaluation);
                $evaluations[] = $evaluation;
            }
        }

        // Notes
        foreach ($evaluations as $evaluation) {
            foreach ($etudiants as $etudiant) {
                $note = new Note();
                $note->setEvaluation($evaluation)
                     ->setEtudiant($etudiant)
                     ->setProgramme($evaluation->getProgramme())
                     ->setValeur(rand(8, 18))
                     ->setStatut('validee')
                     ->setCreatedBy('admin')
                     ->setCreatedAt(new \DateTime());
                $manager->persist($note);
            }
        }

        $manager->flush();
    }
}
