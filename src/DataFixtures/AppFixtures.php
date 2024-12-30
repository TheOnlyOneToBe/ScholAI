<?php

namespace App\DataFixtures;

use App\Entity\Annee;
use App\Entity\Campus;
use App\Entity\Cycle;
use App\Entity\Departement;
use App\Entity\EmploiTemps;
use App\Entity\Etudiant;
use App\Entity\Evaluation;
use App\Entity\Filiere;
use App\Entity\FiliereCycle;
use App\Entity\Inscription;
use App\Entity\Matiere;
use App\Entity\Note;
use App\Entity\PayementMethod;
use App\Entity\PayementReason;
use App\Entity\Professeur;
use App\Entity\Programme;
use App\Entity\Reglement;
use App\Entity\SalleCours;
use App\Entity\Semestre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Création de l'année scolaire
        $annee = new Annee();
        $annee->setYearStart(new \DateTime('2023-09-01'));
        $annee->setYearEnd(new \DateTime('2024-07-31'));
        $annee->setYearStatut(true);
        $manager->persist($annee);

        // Création des campus
        $campusYaounde = new Campus();
        $campusYaounde->setNomCampus('Campus de Yaoundé');
        $campusYaounde->setAdresse('Quartier Ngoa-Ekelle, Yaoundé');
        $manager->persist($campusYaounde);

        $campusDouala = new Campus();
        $campusDouala->setNomCampus('Campus de Douala');
        $campusDouala->setAdresse('Quartier Akwa, Douala');
        $manager->persist($campusDouala);

        $campusBafoussam = new Campus();
        $campusBafoussam->setNomCampus('Campus de Bafoussam');
        $campusBafoussam->setAdresse('Quartier Tamdja, Bafoussam');
        $manager->persist($campusBafoussam);

        // Création des cycles
        $cycles = ['Licence 1', 'Licence 2', 'Licence 3', 'Master 1', 'Master 2'];
        $cyclesObj = [];
        foreach ($cycles as $cycleLibelle) {
            $cycle = new Cycle();
            $cycle->setLibelle($cycleLibelle);
            $manager->persist($cycle);
            $cyclesObj[$cycleLibelle] = $cycle;
        }

        // Création des départements
        $departements = [
            'Informatique et Télécommunications',
            'Sciences de Gestion',
            'Génie Civil',
            'Sciences Biomédicales'
        ];

        $departementsObj = [];
        foreach ($departements as $nomDepartement) {
            $departement = new Departement();
            $departement->setNomDepartement($nomDepartement);
            $departement->setDescription("Département de $nomDepartement");
            $manager->persist($departement);
            $departementsObj[$nomDepartement] = $departement;
        }

        // Création des filières
        $filieres = [
            'Informatique' => 'Informatique et Télécommunications',
            'Réseaux et Systèmes' => 'Informatique et Télécommunications',
            'Finance Comptabilité' => 'Sciences de Gestion',
            'Marketing' => 'Sciences de Gestion',
            'Construction' => 'Génie Civil',
            'Travaux Publics' => 'Génie Civil'
        ];

        $filieresObj = [];
        foreach ($filieres as $nomFiliere => $departement) {
            $filiere = new Filiere();
            $filiere->setLibellefiliere($nomFiliere);
            $manager->persist($filiere);
            $filieresObj[$nomFiliere] = $filiere;
        }

        // Création des associations Filière-Cycle avec stockage dans un tableau
        $filiereCyclesObj = [];
        foreach ($filieresObj as $nomFiliere => $filiere) {
            foreach ($cyclesObj as $nomCycle => $cycle) {
                $filiereCycle = new FiliereCycle();
                $filiereCycle->setFiliere($filiere);
                $filiereCycle->setCycle($cycle);
                $filiereCycle->setInscription(150000);
                $filiereCycle->setPension(850000);
                $filiereCycle->setDescription("Programme de $nomFiliere - $nomCycle");
                $filiereCycle->setStatut(true);
                $manager->persist($filiereCycle);
                $filiereCyclesObj[$nomFiliere][$nomCycle] = $filiereCycle;
            }
        }

        // Création des matières
        $matieres = [
            'Algorithmique',
            'Programmation Web',
            'Base de données',
            'Comptabilité générale',
            'Marketing fondamental',
            'Résistance des matériaux'
        ];

        $matieresObj = [];
        foreach ($matieres as $nomMatiere) {
            $matiere = new Matiere();
            $matiere->setUniteenseignement($nomMatiere);
            $manager->persist($matiere);
            $matieresObj[$nomMatiere] = $matiere;
        }

        // Création des professeurs
        $professeurs = [
            ['KAMGA', 'Paul', 'Informatique et Télécommunications'],
            ['NKENG', 'Marie', 'Sciences de Gestion'],
            ['FOTSO', 'Jean', 'Génie Civil'],
            ['MBARGA', 'Claire', 'Sciences Biomédicales']
        ];

        $professeursObj = [];
        foreach ($professeurs as [$nom, $prenom, $dept]) {
            $professeur = new Professeur();
            $professeur->setNom($nom);
            $professeur->setPrenom($prenom);
            $professeur->setEmail(strtolower($prenom) . '.' . strtolower($nom) . '@schol.cm');
            $professeur->setDepartement($departementsObj[$dept]);
            $manager->persist($professeur);
            $professeursObj[$nom] = $professeur;
        }

        // Création des semestres
        $semestre1 = new Semestre();
        $semestre1->setNomsemestre('Semestre 1');
        $semestre1->setDatedebut(new \DateTime('2023-09-01'));
        $semestre1->setDatefin(new \DateTime('2024-01-31'));
        $manager->persist($semestre1);

        $semestre2 = new Semestre();
        $semestre2->setNomsemestre('Semestre 2');
        $semestre2->setDatedebut(new \DateTime('2024-02-01'));
        $semestre2->setDatefin(new \DateTime('2024-06-30'));
        $manager->persist($semestre2);

        // Création des salles de cours
        $salles = [
            ['A101', 60, $campusYaounde],
            ['A102', 45, $campusYaounde],
            ['A201', 80, $campusYaounde],
            ['Amphi 1', 200, $campusYaounde],
            ['B101', 50, $campusDouala],
            ['B102', 40, $campusDouala],
            ['B201', 70, $campusDouala],
            ['Amphi 2', 150, $campusDouala],
            ['C101', 45, $campusBafoussam],
            ['C102', 35, $campusBafoussam],
            ['Amphi 3', 100, $campusBafoussam]
        ];

        $sallesObj = [];
        foreach ($salles as [$nomSalle, $capacite, $campus]) {
            $salle = new SalleCours();
            $salle->setNomSalle($nomSalle);
            $salle->setCapacite($capacite);
            $salle->setCampus($campus);
            $manager->persist($salle);
            $sallesObj[$nomSalle] = $salle;
        }

        // Création des méthodes de paiement
        $methodePaiements = ['Espèces', 'Mobile Money', 'Virement Bancaire'];
        $methodePaiementsObj = [];
        foreach ($methodePaiements as $methode) {
            $methodePaiement = new PayementMethod();
            $methodePaiement->setPayementName($methode);
            $manager->persist($methodePaiement);
            $methodePaiementsObj[$methode] = $methodePaiement;
        }

        // Création des raisons de paiement
        $raisonsPaiement = ['Inscription', 'Scolarité', 'Examen'];
        $raisonsPaiementObj = [];
        foreach ($raisonsPaiement as $raison) {
            $raisonPaiement = new PayementReason();
            $raisonPaiement->setLibelleRaison($raison);
            $manager->persist($raisonPaiement);
            $raisonsPaiementObj[$raison] = $raisonPaiement;
        }

        // Création des étudiants et leurs inscriptions
        $filieresList = array_keys($filieresObj);
        $cyclesList = array_keys($cyclesObj);

        for ($i = 0; $i < 50; $i++) {
            $etudiant = new Etudiant();
            $etudiant->setNoms($faker->lastName);
            $etudiant->setPrenoms($faker->firstName);
            $etudiant->setAge($faker->numberBetween(18, 25));
            $etudiant->setTelephone($faker->phoneNumber);
            $etudiant->setAdresseStudent($faker->address);
            $etudiant->setSexeEtudiant($faker->randomElement(['M', 'F']));
            $etudiant->setMatriculeStudent('ST' . str_pad($i + 1, 4, '0', STR_PAD_LEFT));
            $etudiant->setStudentFather($faker->name('male'));
            $etudiant->setStudentMother($faker->name('female'));
            $etudiant->setFatherNumber($faker->phoneNumber);
            $etudiant->setMotherNumber($faker->phoneNumber);
            $etudiant->setStudentEmail($faker->email);
            $manager->persist($etudiant);

            // Sélection aléatoire d'une filière et d'un cycle
            $filiereChoisie = $faker->randomElement($filieresList);
            $cycleChoisi = $faker->randomElement($cyclesList);
            
            // Récupération du FiliereCycle correspondant
            $filiereCycle = $filiereCyclesObj[$filiereChoisie][$cycleChoisi];

            // Création de l'inscription
            $inscription = new Inscription();
            $inscription->setDateInscription(new \DateTime());
            $inscription->setStatutInscription(true);
            $inscription->setFilierecycle($filiereCycle);
            $inscription->setAnnee($annee);
            $inscription->setEtudiant($etudiant);
            $manager->persist($inscription);

            // Création du règlement
            $reglement = new Reglement();
            $reglement->setOntantReglement(150000);
            $reglement->setDateReglement(new \DateTime());
            $reglement->setInscription($inscription);
            $reglement->setPayementMethod($methodePaiementsObj['Mobile Money']);
            $reglement->setPayementReason($raisonsPaiementObj['Inscription']);
            $manager->persist($reglement);
        }

        // Création des programmes
        foreach ($matieresObj as $matiere) {
            foreach ($filiereCyclesObj as $filiereNom => $cyclesMap) {
                foreach ($cyclesMap as $cycleNom => $filiereCycle) {
                    $programme = new Programme();
                    $programme->setMatiere($matiere);
                    $programme->setProfesseur($faker->randomElement($professeursObj));
                    $programme->setFiliereCycle($filiereCycle);
                    $programme->setAnnee($annee);
                    $programme->setSemestre($semestre1);
                    $programme->setHeurealloue($faker->numberBetween(30, 60));
                    $manager->persist($programme);

                    // Création des évaluations
                    $evaluation = new Evaluation();
                    $evaluation->setProgramme($programme);
                    $evaluation->setSemestre($semestre1);
                    $evaluation->setTitre("Examen de " . $matiere->getUniteenseignement());
                    $evaluation->setDescription("Evaluation finale");
                    $evaluation->setDateEvaluation(new \DateTime());
                    $evaluation->setType("Examen");
                    $evaluation->setCoefficient(2);
                    $evaluation->setCreatedAt(new \DateTime());
                    $evaluation->setCreatedBy("System");
                    $manager->persist($evaluation);

                    // Création des emplois du temps
                    $emploiTemps = new EmploiTemps();
                    $emploiTemps->setSalle($faker->randomElement($sallesObj));
                    $emploiTemps->setProgramme($programme);
                    $emploiTemps->setDate($faker->dateTimeBetween('2023-09-01', '2024-06-30'));
                    $emploiTemps->setHeureDebut(new \DateTime('08:00'));
                    $emploiTemps->setHeureFin(new \DateTime('10:00'));
                    $manager->persist($emploiTemps);

                    // Création des notes
                    foreach ($manager->getRepository(Etudiant::class)->findAll() as $etudiant) {
                        $note = new Note();
                        $note->setEvaluation($evaluation);
                        $note->setEtudiant($etudiant);
                        $note->setProgramme($programme);
                        $note->setValeur($faker->randomFloat(2, 8, 20));
                        $note->setCommentaire($faker->sentence);
                        $note->setStatut('Validé');
                        $note->setCreatedAt(new \DateTime());
                        $note->setCreatedBy('System');
                        $manager->persist($note);
                    }
                }
            }
        }

        $manager->flush();
    }
}
